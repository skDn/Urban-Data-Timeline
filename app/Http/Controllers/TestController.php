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
define("USEDIFF" , false);



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
		$sectionDate = null;
		$currentDate = null;
		$section = null;
		$previousdiff = 0;
		foreach ($tweets as $tweet) {
			
			$date = new DateTime($tweet->created_at);
			
			if ($sectionDate === null) {
				$sectionDate = $date->format(DATEASID);
				$section = array(
					'id' => $sectionDate,
					'tweets' => array(),
				);
			}
			elseif ($sectionDate != $date->format(DATEASID)) {
				
				$sectionDate = $date->format(DATEASID);
				
				array_push($response['section'], $section);
				$section = array(
					'id' => $sectionDate,
					'tweets' => array(),
				);
			}

			if(USEDIFF) {
				$diff = ($currentDate === null) ? 0 : $date->diff($currentDate);
				$diff = (!is_object($diff) || ($diff->y == 0 && $diff->m  == 0 && $diff->d  == 0 && 
							$diff->h == 0 && $diff->i == 0)) ? $previousdiff : round(log($diff->i + $diff->h*60 + $diff->d*3600,2));	
			}
			else {
				$diff = 0;
			}
			$tweet = array(
				'name' => $tweet->user->name,
				'screen_name' => $tweet->user->screen_name,
				'text' => Twitter::linkify($tweet->text),
				'created_at' => $date->format(DATEASCONTENT),
				/* trying to smooth the distance between two events */
				'diff' => $diff,
				'original' => Twitter::linkTweet($tweet),
			);
			$currentDate = $date;
			$previousdiff = $diff;
			array_push($section['tweets'], $tweet);
		}
		// dd($response);
		return view('test.test')->with('data', $response)->withInput($request->all());
    }
}
 