<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 17/01/2016
 * Time: 22:27
 */
namespace Urban\Http\Middleware;

use Cache;
use DateTime as DateTime;
use Illuminate\Http\Request;
use Urban\Models\BusyVenues;
use Urban\Models\Twitter;
use Urban\Models\TwitterTimeline;

define("DATEASID", "ha");
define("USEDIFF", false);


class SearchHelper
{
    public function getResultsForEvent($query, Request $request)
    {

        $cacheTag = 'fullResponse'; //config timeline twitter

        $cacheKey = '';

        $cacheLimit = 15;

        $requestParameters = array_values($request->all());
        array_pop($requestParameters);


        foreach ($requestParameters as $value) {
            $cacheKey .= $value;
        }
//
//        foreach ($requestParameters as $value) {
//            if ($this->isFirst($query, $request)) {
//                if ($value !== $request->input("querySecond")) {
//                    $cacheKey .= $value;
//                }
//            } else {
//                if ($value !== $request->input("queryFirst")) {
//                    $cacheKey .= $value;
//                }
//            }
//        }

//        dd($cacheKey);
//        if (Cache::has($cacheKey)) {
//            return Cache::get($cacheKey);
//        }

        $date = $request->input('date');
        $query = ($query) ? $query : $request->input('twitterAccount');
        $twitterAccount = $request->input('twitterAccount');
        $twitTimeline = ($twitterAccount) ? new TwitterTimeline($twitterAccount, $date) : new TwitterTimeline($query, $date);
//        dd($twitTimeline->getData());
        $twit = new Twitter($query, $date);


        $lat = $request->input('lat');
        $lng = $request->input('lng');

        // if there are any train stations nearby
//        $delayedService = new DelaysTimeSeries($date);
//        $delayedService = new DelayedServices($date);
//        $delayedService->getDate('GLGQHL');
        //dd($stations);
        /* TODO: delayed service bug
        $trainStations = new TrainStations($lat, $lng);
        $stations = $trainStations->getData($date, 0, 10);
        // if there are any train stations nearby
        //dd($stations);
        if (count($stations) > 0) {
            $delayedService = new DelayedServices($date);
            foreach ($stations as $station) {
                $delayedService->getDate($station['tiploc']);
            }
        }
        */

        $venues = new BusyVenues($lat, $lng, $date, null);

        /**
         * sorting the array
         */

        $searchToken = $request->input('searchToken');

        $mergeQueries = array_merge((array)$twit->getData(),
            ($searchToken && $searchToken === 'venue') ?
                (array)$venues->getVenueData(strtotime($date)) : (array)$venues->getData(),
            (array)$twitTimeline->getData()
        );
        usort($mergeQueries, array($this, 'date_compare'));

        $response = array(
            'sections' => array(),
            'info' => array(),
        );
        /* getting sections */
        $response['sections'] = $this->generateSections($mergeQueries);

        $twitterInfo = $twit->getInfo();
        if (count($twitterInfo) > 0) {
            $response['info']['twitter'] = $twitterInfo;
        }

        if (count($response['sections']) > 0 && $request->input('querySecond') == null) { //&& !is_null(Cache::get($cacheKey))) {
            Cache::put($cacheKey, $response, $cacheLimit);
        }

        return $response;
    }

    function date_compare($a, $b)
    {
        $t1 = strtotime($a['dateString']);
        $t2 = strtotime($b['dateString']);
        return $t1 - $t2;
    }

    /**
     * @param $mergeQueries
     * @return array
     */
    private function generateSections($mergeQueries)
    {
        $sectionDate = null;
        $currentDate = null;
        $section = null;
        $previousDifference = 0;
        $response = array();
        foreach ($mergeQueries as $event) {

            $date = new DateTime($event['dateString']);

            if ($sectionDate === null) {
                $sectionDate = $date->format(DATEASID);
                $section = array(
                    'id' => $sectionDate,
                    'events' => array(),
                );
            } elseif ($sectionDate != $date->format(DATEASID)) {

                $sectionDate = $date->format(DATEASID);

                array_push($response, $section);
                $section = array(
                    'id' => $sectionDate,
                    'events' => array(),
                );
            }

            if (USEDIFF) {
                $diff = ($currentDate === null) ? 0 : $date->diff($currentDate);
                $diff = (!is_object($diff) || $this->my_first_condition($diff))
                    ? $previousDifference : round(log($diff->i + $diff->h * 60 + $diff->d * 3600, 2));
            } else {
                $diff = 0;
            }
            $currentDate = $date;
            $previousDifference = $diff;
            array_push($section['events'], $event);
        }
        return $response;
    }

    private function my_first_condition($diff)
    {
        return $diff->y == 0 && $diff->m == 0 && $diff->d == 0 &&
        $diff->h == 0 && $diff->i == 0;
    }

    private function isFirst($query, $request)
    {
        if ($request->input('queryFirst') === $query) {
            return true;
        }
        return false;
    }
}