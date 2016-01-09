<?php
/**
 * Created by IntelliJ IDEA.
 * User: yordanyordanov
 * Date: 16/12/2015
 * Time: 13:04
 */

namespace Urban\Http\Controllers;



use Validator;
use Illuminate\Http\Request;
use Urban\Http\Controllers\Controller;

use Urban\Models\BusyVenues;
use Urban\Models\Twitter;
use Urban\Models\TwitterTimeline;
use \DateTime as DateTime;

class SearchControllerV2 extends Controller
{
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
    private function rules()
    {
        return [
            'query'.$this->firstID => 'max:100|alpha_dash',
            'date' => 'required|date',
//            digits_between:min,max for lat/lng
            'lat' => 'required',
            'lng' => 'required',
        ];
    }

    public function getResults(Request $request)
    {
        // create the validation rules ------------------------
//        $this->validate($request, [
//            'title' => 'required|unique|max:255',
//            'body' => 'required',
//        ]);

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
//            dd($validator->errors()->all());
            return redirect()->route('event')
                ->withErrors($validator)
                ->withInput();
        }

        $query = $request->input('query' . $this->firstID);
        // use this if more than one date picker
        //$date = $request->input('date' . $this->firstID);
        $date = $request->input('date');
//        if (!$query) {
//            return redirect()->route('event');
//        }

        $twitTimeline = new TwitterTimeline($query);

        $twit = new Twitter($query);

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $venues = new BusyVenues($lat, $lng);

        //dd($venues->getVenueData(strtotime($date)));

        $firstElement = array(
            'id' => $this->firstID,
        );
        /**
         * sorting the array
         */
        //dd($twit->getData(strtotime($date), 0, 10));

        $searchToken = $request->input('searchToken');

        $mergeQueries = array_merge((array)$twit->getData(strtotime($date), 0, 10),
            ($searchToken && $searchToken === 'venue') ? (array)$venues->getVenueData(strtotime($date)) : (array)$venues->getData(strtotime($date), 0 ,10),
            (array)$twitTimeline->getData(strtotime($date), 0, 10)
            );
        usort($mergeQueries, array($this, 'date_compare'));
//        dd($mergeQueries);


        /*
    section => array(
        'id' => ,
        'events' => array (
            'name' => ,
            'screen_name' => ,
            'text' => ,
            'created_at' => ,
        ) )


*/

        $response = array(
            'elements' => array(
                'first' => $firstElement,
            ),
            'sections' => array(),
//            'response' => array(
//                'twitter' => $twit->getData(strtotime($date), 0, 10),
//                'venues' => $venues->getData(strtotime($date), 0 , 20),
//            )
        );
        /* getting sections */
        $sectionDate = null;
        $currentDate = null;
        $section = null;
        $previousdiff = 0;
        foreach ($mergeQueries as $event) {

            $date = new DateTime($event['dateString']);

            if ($sectionDate === null) {
                $sectionDate = $date->format(DATEASID);
                $section = array(
                    'id' => $sectionDate,
                    'events' => array(),
                );
            }
            elseif ($sectionDate != $date->format(DATEASID)) {

                $sectionDate = $date->format(DATEASID);

                array_push($response['sections'], $section);
                $section = array(
                    'id' => $sectionDate,
                    'events' => array(),
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
//
//            $tweet = array(
//                'name' => $tweet->user->name,
//                'screen_name' => $tweet->user->screen_name,
//                'text' => Twitter::linkify($tweet->text),
//                'created_at' => $date->format(DATEASCONTENT),
//                /* trying to smooth the distance between two events */
//                'diff' => $diff,
//                'original' => Twitter::linkTweet($tweet),
//            );
            $currentDate = $date;
            $previousdiff = $diff;
            array_push($section['events'], $event);
        }
        //dd($response);
//        dd(Input::all());
//        dd($request->all());
        return view('search.resultV2')->with('data', $response)->withInput($request->all());
    }
}