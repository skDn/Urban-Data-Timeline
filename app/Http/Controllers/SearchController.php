<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 07/11/2015
 * Time: 23:17
 */

namespace Urban\Http\Controllers;

use Illuminate\Http\Request;
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

        $firstElement = array(
            'id' => $this->firstID,
            'query' => $query,
            'date' => $date,
        );
        $response = array(
            'elements' => array(
                'first' => $firstElement,
            ),
            'response' => $twit->getData(strtotime($date), 0, 10),
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
        $date = strtotime($request->input('date'));

        $range = floor(config('controls.countReportRange') / 2);

        $dateStart = strtotime('-' . $range . ' days', $date);
        $dateEnd = strtotime('+' . $range . ' days', $date);

        if (!$query) {
            return redirect()->route('event');
        }

        $twit = new Twitter($query);

        //return $twit->getCount($this->getDateObject($day, $month, $year));
        $returnData = array(
            $query => $twit->getCountForRange($dateStart, $dateEnd),
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

        $response = array(
            'responseFirst' => $twitFirst->getData(strtotime($dateFirst),0,10),
            'responseSecond' => $twitSecond->getData(strtotime($dateSecond),0,10),
            'elements' => array(
                'first' => $firstElement,
                'second' => $secondElement,
            )
        );
        return view('comparison.result')->with('data', $response);
    }

}