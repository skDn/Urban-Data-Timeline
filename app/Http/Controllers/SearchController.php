<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 07/11/2015
 * Time: 23:17
 */

namespace Urban\Http\Controllers;

use Illuminate\Http\Request;
use Urban\Twitter;

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
        $day = $request->input('day' . $this->firstID);
        $month = $request->input('month' . $this->firstID);
        $year = $request->input('year' . $this->firstID);
        if (!$query) {
            return redirect()->route('event');
        }

        $twit = new Twitter($query);

        $firstElement = array(
            'id' => $this->firstID,
            'query'=> $query,
            'day'=> $day,
            'month'=> $month,
            'year'=> $year,
        );
        $response = array(
            'elements' => array(
                'first' => $firstElement,
            ),
            'response' => $twit->getUsers($this->matchParametersToRegex($day, $month, $year)),
        );
        return view('search.result')->with('data', $response);
        //return
    }

    private function matchParametersToRegex($d, $m, $y)
    {
        $month = sprintf("%02d", $m);
        $day = sprintf("%02d", $d);
        return $y . '-' . $month . '-' . $day;
    }

    public function getUserCount(Request $request)
    {
        $query = $request->input('query');
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        if (!$query) {
            return redirect()->route('event');
        }

        $twit = new Twitter($query);

        return $twit->getNumberOfTweetsForDay($this->matchParametersToRegex($day, $month, $year));
    }

    public function compareTwoEvents(Request $request)
    {
        $queryFirst = $request->input('query' . $this->firstID);
        $dayFirst = $request->input('day' . $this->firstID);
        $monthFirst = $request->input('month' . $this->firstID);
        $yearFirst = $request->input('year' . $this->firstID);

        $querySecond = $request->input('query' . $this->secondID);
        $daySecond = $request->input('day' . $this->secondID);
        $monthSecond = $request->input('month' . $this->secondID);
        $yearSecond = $request->input('year' . $this->secondID);

        $querySecond = $request->input('querySecond');

        if (!$queryFirst && !$querySecond) {
            return redirect()->route('event');
        }

        $input = array(
            'queryFirst' => $queryFirst,
            'querySecond' => $querySecond,
//            'day' => $dayFirst,
//            'month' => $monthFirst,
//            'year' => $yearFirst,
        );

        $twitFirst = new Twitter($queryFirst);

        $twitSecond = new Twitter($querySecond);

        $firstElement = array(
            'id' => $this->firstID,
            'query'=> $queryFirst,
            'day'=> $dayFirst,
            'month'=> $monthFirst,
            'year'=> $yearFirst,
        );
        $secondElement = array(
            'id' => $this->secondID,
            'query'=> $querySecond,
            'day'=> $daySecond,
            'month'=> $monthSecond,
            'year'=> $yearSecond,
        );

        $response = array(
            'responseFirst' => $twitFirst->getUsers($this->matchParametersToRegex($dayFirst, $monthFirst, $yearFirst)),
            'responseSecond' => $twitSecond->getUsers($this->matchParametersToRegex($daySecond, $monthSecond, $yearSecond)),
            'elements' => array(
                'first' => $firstElement,
                'second' => $secondElement,
            )
        );
        return view('comparison.result')->with('data', $response);
    }

}