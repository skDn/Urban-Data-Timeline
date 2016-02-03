<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 17/01/2016
 * Time: 22:27
 */
namespace Urban\Http\Middleware;

use Illuminate\Http\Request;

use Urban\Models\BusyVenues;
use Urban\Models\Twitter;
use Urban\Models\TwitterTimeline;
use Urban\Models\TrainStations;
use Urban\Models\DelayedServices;

use \DateTime as DateTime;

class SearchHelper
{
    public function getResultsForEvent($query, Request $request)
    {
        //$query = $request->input('query' . $this->firstID);
        // use this if more than one date picker
        //$date = $request->input('date' . $this->firstID);
        $date = $request->input('date');
//        if (!$query) {
//            return redirect()->route('event');
//        }
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
            ($searchToken && $searchToken === 'venue') ? (array)$venues->getVenueData(strtotime($date)) : (array)$venues->getData(strtotime($date), 0, 10),
            (array)$twitTimeline->getData(strtotime($date), 0, 10)
        );
        usort($mergeQueries, array($this, 'date_compare'));
//        dd($mergeQueries);


        /* SECTION FORMAT
    section => array(
        'id' => ,
        'events' => array (
            'name' => ,
            'screen_name' => ,
            'text' => ,
            'created_at' => ,
        ) )
        */

        $response = array(
            'sections' => array(),
            'info' => array(),
        );
        /* getting sections */
        $response['sections'] = $this->generateSections($mergeQueries);


        //$response['info'] = $twit->getInfo(strtotime($date));
        $response['info']['twitter'] = $twit->getInfo(strtotime($date));

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
        $previousdiff = 0;
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
                $diff = (!is_object($diff) || ($diff->y == 0 && $diff->m == 0 && $diff->d == 0 &&
                        $diff->h == 0 && $diff->i == 0)) ? $previousdiff : round(log($diff->i + $diff->h * 60 + $diff->d * 3600, 2));
            } else {
                $diff = 0;
            }
//
//            $tweet = array(
//                'name' => $tweet->user->name,
//                'screen_name' => $tweet->user->screen_name,
//                'text' => Twitter::linkify($tweet->text),
//                'created_at' => $date->format(DATEASCONTENT),
//                /* trying to smooth the distance between two events */
//                'diff' => $diff,
//                'original' => Twitter::linkTweet($tweet),
//            );
            $currentDate = $date;
            $previousdiff = $diff;
            array_push($section['events'], $event);
        }
        return $response;
    }
}