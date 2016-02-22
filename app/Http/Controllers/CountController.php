<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 22/11/2015
 * Time: 21:57
 */

namespace Urban\Http\Controllers;

use Illuminate\Http\Request;
use Urban\Models\BusyVenues;
use Urban\Models\Twitter;

class CountController extends Controller
{
    public function getUserCount(Request $request)
    {

        // add validator
        $query = $request->input('query');
        if (!$query) {
            $query = $request->input('queryFirst');
        }
        $date = $request->input('date');

        $rangeFromRequest = $request->input('range');

        $range = ($rangeFromRequest) ? $rangeFromRequest : floor(config('controls.countReportRange') / 2);

        if ($range == 1) {
            $dateStart = $dateEnd = strtotime($date);
        } else {
            $range /=2;
            $range = floor($range);
            $dateStart = strtotime('-' . $range . ' days', strtotime($date));
            $dateEnd = strtotime('+' . $range . ' days', strtotime($date));
        }

        $twit = new Twitter($query, $date);

        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $venues = new BusyVenues($lat, $lng, $date, null);

        $returnData = array(
            $query => array(
                'twitter' => $twit->getCountForRange($dateStart, $dateEnd),
                'venues' => $venues->getCountForRange($dateStart, $dateEnd),
            )
        );
        return json_encode($returnData);
    }
}