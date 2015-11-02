<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 2.11.2015 ?.
 * Time: 02:52 ?.
 */

namespace Urban\Http\Controllers;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.search');
    }
    public function getResults()
    {
        return view('search.result');
    }

}