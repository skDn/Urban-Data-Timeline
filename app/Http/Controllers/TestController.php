<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 10/12/2015
 * Time: 23:17
 */
namespace Urban\Http\Controllers;

define("DATEASID",     "M-d");
define("DATEASCONTENT",     "Y-m-d h:i");



use Validator;
use Illuminate\Http\Request;
use Urban\Http\Controllers\Controller;

use Thujohn\Twitter\Facades\Twitter;
use \DateTime as DateTime;

class TestController extends Controller
{
    public function test(Request $request)
    {
    	$response = array(
    		'info' => array(
    			'name' => null,
    			'description' => null,
    			'screen_name' => null,
    			'location' => null,
    			),
    		'section' =>array(),
    	);

    	/*
			section => array(
				'id' => ,
				'tweets' => array (
					'name' => ,
					'screen_name' => ,
					'text' => ,
					'created_at' => ,
				) )
    	*/

		$tweets = Twitter::getUserTimeline(['screen_name' => 'ketchupwestend', 'count' => 20, 'format' => 'object']);
		
		/* getting venue info */

		$first = array_values($tweets)[0]->user;

		$response['info']['name'] = $first->name;
		$response['info']['description'] = $first->description;
		$response['info']['screen_name'] = $first->screen_name;
		$response['info']['location'] = $first->location;
		$response['info']['profile_image_url'] = $first->profile_image_url;

		/* getting sections */
		$currentDate = null;
		$section = null;
		foreach ($tweets as $tweet) {
			
			$date = new DateTime($tweet->created_at);
			
			if ($currentDate === null) {
				$currentDate = $date->format(DATEASID);
				$section = array(
					'id' => $currentDate,
					'tweets' => array(),
				);
			}
			elseif ($currentDate != $date->format(DATEASID)) {
				
				$currentDate = $date->format(DATEASID);
				
				array_push($response['section'], $section);
				$section = array(
					'id' => $currentDate,
					'tweets' => array(),
				);
			}
			$tweet = array(
				'name' => $tweet->user->name,
				'screen_name' => $tweet->user->screen_name,
				'text' => $tweet->text,
				'created_at' => $date->format(DATEASCONTENT),
			);
			array_push($section['tweets'], $tweet);
		}

		return view('test.test')->with('data', $response)->withInput($request->all());
    }
}
 