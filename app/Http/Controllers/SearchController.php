<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 2.11.2015 ?.
 * Time: 02:52 ?.
 */

namespace Urban\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.search');
    }
    public function getResults(Request $request)
    {
    	$query = $request->input('query');

    	if (!$query) 
    	{
    		return redirect()->route('event');
    	}
  //   	$mockdata = array(
		//     'title'  => $query,
		//     'text' => 'mockdata',
		// ); 
    	$mockdata = array_fill(0,10,array(
		    'title'  => $query,
		    'text' => 'mockdata',
		));

    	return view('search.result')->with('data', $mockdata);
        //return view('search.result');
    }

}