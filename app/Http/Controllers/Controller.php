<?php

namespace Urban\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Urban\Models\BusyVenues;
use Urban\Models\Twitter;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $firstID = 'First';
    protected $secondID = 'Second';

    function date_compare($a, $b)
    {
        $t1 = strtotime($a['dateString']);
        $t2 = strtotime($b['dateString']);
        return $t1 - $t2;
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
}
