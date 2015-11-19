<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 07/11/2015
 * Time: 23:17
 */

namespace Urban\Http\Controllers;

use Illuminate\Http\Request;
use Urban\Models\BusyVenues;
use Urban\Models\Twitter;

class SearchController extends Controller
{
    protected $firstID = 'First';
    protected $secondID = 'Second';

    public function event()
    {
        $firstElement = array(
            'id' => $this->firstID,
        );
        return view('search.search')->with('data',
            array(
                'elements' => array(
                    'first' => $firstElement,
                )
            )
        );
    }

    public function comparison()
    {
        $firstElement = array(
            'id' => $this->firstID,
        );
        $secondElement = array(
            'id' => $this->secondID,
        );
        return view('comparison.comparison')->with('data',
            array(
                'elements' => array(
                    'first' => $firstElement,
                    'second' => $secondElement,
                )
            )
        );
    }

    function date_compare($a, $b)
    {
        $t1 = strtotime($a['dateString']);
        $t2 = strtotime($b['dateString']);
        return $t1 - $t2;
    }

    public function getResults(Request $request)
    {
        $query = $request->input('query' . $this->firstID);
        // use this if more than one date picker
        //$date = $request->input('date' . $this->firstID);
        $date = $request->input('date');
        if (!$query) {
            return redirect()->route('event');
        }

        $twit = new Twitter($query);

        $lat = 55.8748;
        $lon = -4.2929;
        $venues = new BusyVenues($lat, $lon);

        $firstElement = array(
            'id' => $this->firstID,
            'query' => $query,
            'date' => $date,
        );
        /**
         * sorting the array
         */
        $mergeQueries = array_merge($twit->getData(strtotime($date), 0, 10), $venues->getData(strtotime($date), 0, 20));
        usort($mergeQueries, array($this, 'date_compare'));
        $response = array(
            'elements' => array(
                'first' => $firstElement,
            ),
            'response' => $mergeQueries,
//            'response' => array(
//                'twitter' => $twit->getData(strtotime($date), 0, 10),
//                'venues' => $venues->getData(strtotime($date), 0 , 20),
//            )
        );
        //dd($response);
        return view('search.result')->with('data', $response);
        //return
    }


    private function matchParametersToRegex($d, $m, $y)
    {
        $month = sprintf("%02d", $m);
        $day = sprintf("%02d", $d);
        return $y . '-' . $month . '-' . $day;
        //return mktime(0, 0, 0, $m, $d, $y);
    }

    private function getDateObject($d, $m, $y)
    {
        $month = sprintf("%02d", $m);
        $day = sprintf("%02d", $d);
        //return $y . '-' . $month . '-' . $day;
        return mktime(0, 0, 0, $m, $d, $y);
    }

    public function getUserCount(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            $query = $request->input('queryFirst');
        }
        $date = strtotime($request->input('date'));

        $range = floor(config('controls.countReportRange') / 2);

        $dateStart = strtotime('-' . $range . ' days', $date);
        $dateEnd = strtotime('+' . $range . ' days', $date);

        if (!$query) {
            return redirect()->route('event');
        }

        $twit = new Twitter($query);

        $lat = 55.8748;
        $lon = -4.2929;
        $venues = new BusyVenues($lat, $lon);

        //return $twit->getCount($this->getDateObject($day, $month, $year));
        $returnData = array(
            $query => array(
                'twitter' => $twit->getCountForRange($dateStart, $dateEnd),
                'venues' => $venues->getCountForRange($dateStart, $dateEnd),
            )
        );
        return json_encode($returnData);
    }

    public function compareTwoEvents(Request $request)
    {
        $queryFirst = $request->input('query' . $this->firstID);
        //$dateFirst = $request->input('date' . $this->firstID);

        $querySecond = $request->input('query' . $this->secondID);
        //$dateSecond = $request->input('date' . $this->secondID);
        $dateFirst = $dateSecond = $request->input('date');


        if (!$queryFirst && !$querySecond) {
            return redirect()->route('event');
        }

        $input = array(
            'queryFirst' => $queryFirst,
            'querySecond' => $querySecond,
        );

        $twitFirst = new Twitter($queryFirst);

        $twitSecond = new Twitter($querySecond);

        $lat = 55.8748;
        $lon = -4.2929;
        $venues = new BusyVenues($lat, $lon);

        $firstElement = array(
            'id' => $this->firstID,
            'query' => $queryFirst,
            'date' => $dateFirst,
        );
        $secondElement = array(
            'id' => $this->secondID,
            'query' => $querySecond,
            'date' => $dateSecond,
        );

        /**
         * sorting the array
         */
        $ven = $venues->getData(strtotime($dateFirst), 0, 20);

        $mergeQueries1 = array_merge($twitFirst->getData(strtotime($dateFirst), 0, 10), $ven);
        usort($mergeQueries1, array($this, 'date_compare'));

        $mergeQueries2 = array_merge($twitSecond->getData(strtotime($dateSecond), 0, 10), $ven);
        usort($mergeQueries2, array($this, 'date_compare'));

        $response = array(
            'responseFirst' => $mergeQueries1,
            'responseSecond' => $mergeQueries2,
            'elements' => array(
                'first' => $firstElement,
                'second' => $secondElement,
            )
        );
        return view('comparison.result')->with('data', $response);
    }

}