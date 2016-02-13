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

        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $venues = new BusyVenues($lat, $lng);

        $returnData = array(
            $query => array(
                'twitter' => $twit->getCountForRange($dateStart, $dateEnd),
                'venues' => $venues->getCountForRange($dateStart, $dateEnd),
            )
        );
        return json_encode($returnData);
    }
}