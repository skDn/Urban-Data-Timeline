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
use Urban\Models\DelayedServices;
use Urban\Models\TrainStations;

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
/**
 *      UNCOMMENT IF USING INFINITE SCROLLING IN THE COMPARISON VIEW
 */
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

//        if (Cache::has($cacheKey)) {
//            return Cache::get($cacheKey);
//        }

        $date = $request->input('date');
        $query = ($query) ? $query : $request->input('twitterAccount');
        $twitterAccount = $request->input('twitterAccount');
        $twitTimeline = ($twitterAccount) ? new TwitterTimeline($twitterAccount, $date) : new TwitterTimeline($query, $date);
        $twit = new Twitter($query, $date);


        $lat = $request->input('lat');
        $lng = $request->input('lng');

/**
 *      UNCOMMENT IF DELAYED SERVICES API WORKS
 */
//        $trainStations = new TrainStations($lat, $lng, $date);
//        $stations = $trainStations->getData();
//        // if there are any train stations nearby
//        if (count($stations) > 0) {
//            $delayedService = new DelayedServices($date);
//            foreach ($stations as $station) {
//                $delayedService->getDate($station['tiploc']);
//            }
//        }
        // */

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

    private function generateSections($mergeQueries)
    {
        $sectionDate = null;
        $currentDate = null;
        $section = null;
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
            array_push($section['events'], $event);
        }
        return $response;
    }

    private function isFirst($query, $request)
    {
        if ($request->input('queryFirst') === $query) {
            return true;
        }
        return false;
    }
}