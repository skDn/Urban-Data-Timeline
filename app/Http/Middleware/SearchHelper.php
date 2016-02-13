<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 17/01/2016
 * Time: 22:27
 */
namespace Urban\Http\Middleware;

use DateTime as DateTime;
use Illuminate\Http\Request;
use Urban\Models\BusyVenues;
use Urban\Models\Twitter;
use Urban\Models\TwitterTimeline;

class SearchHelper
{
    public function getResultsForEvent(Request $request)
    {
        $date = $request->input('date');
        $query = ($request->input('queryFirst')) ? $request->input('queryFirst') : $request->input('twitterAccount');
        $twitterAccount = $request->input('twitterAccount');
        $twitTimeline = ($twitterAccount) ? new TwitterTimeline($twitterAccount) : new TwitterTimeline($query);

        $twit = new Twitter($query);


        $lat = $request->input('lat');
        $lng = $request->input('lng');

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


        $venues = new BusyVenues($lat, $lng);

        /**
         * sorting the array
         */

        $searchToken = $request->input('searchToken');

        $mergeQueries = array_merge((array)$twit->getData(strtotime($date), 0, 10),
            ($searchToken && $searchToken === 'venue') ?
                (array)$venues->getVenueData(strtotime($date)) : (array)$venues->getData(strtotime($date), 0, 10),
            (array)$twitTimeline->getData(strtotime($date), 0, 10)
        );
        usort($mergeQueries, array($this, 'date_compare'));

        $response = array(
            'sections' => array(),
            'info' => array(),
        );
        /* getting sections */
        $response['sections'] = $this->generateSections($mergeQueries);

        $twitterInfo = $twit->getInfo(strtotime($date));
        if (count($twitterInfo) > 0) {
            $response['info']['twitter'] = $twitterInfo;
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
                $diff = (!is_object($diff) || $this->my_first_condition())
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
}