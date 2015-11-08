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
    public function index()
    {
        return view('search.search');
    }

    public function getResults(Request $request)
    {
        $query = $request->input('query');
        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        if (!$query) {
            return redirect()->route('event');
        }

        $input = array(
            'query' => $query,
            'day' => $day,
            'month' => $month,
            'year' => $year,
        );

        $twit = new Twitter($query);

        $response = array(
            'search' => $input,
            'response' => $twit->getUsers($this->matchParametersToRegex($day, $month, $year)),
        );
        return view('search.result')->with('data', $response);
        //return
    }

    private function matchParametersToRegex($d, $m, $y)
    {
        $month = sprintf("%02d", $m);
        $day = sprintf("%02d", $d);
        return $y.'-'.$month.'-'.$day;
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

        echo $twit->getNumberOfTweetsForDay($this->matchParametersToRegex($day, $month, $year));
    }

}