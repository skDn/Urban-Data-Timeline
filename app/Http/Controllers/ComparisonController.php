<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 22/11/2015
 * Time: 21:50
 */

namespace Urban\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Urban\Http\Controllers\Controller;

use Urban\Models\BusyVenues;
use Urban\Models\Twitter;


class ComparisonController extends Controller
{
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

    private function rules()
    {
        return [
            'query'.$this->firstID => 'required|max:100|alpha_dash',
            'query'.$this->secondID => 'required|max:100|alpha_dash',
            'date' => 'required|date',
//            digits_between:min,max for lat/lng
            'lat' => 'required',
            'lng' => 'required',
        ];
    }

    public function compareTwoEvents(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
//            dd($validator->errors()->all());
            return redirect()->route('comparison')
                ->withErrors($validator)
                ->withInput();
        }

        $queryFirst = $request->input('query' . $this->firstID);
        //$dateFirst = $request->input('date' . $this->firstID);

        $querySecond = $request->input('query' . $this->secondID);
        //$dateSecond = $request->input('date' . $this->secondID);
        $dateFirst = $dateSecond = $request->input('date');


        if (!$queryFirst && !$querySecond) {
            return redirect()->route('event');
        }

        $input = array(
            'queryFirst' => $queryFirst,
            'querySecond' => $querySecond,
        );

        $twitFirst = new Twitter($queryFirst);

        $twitSecond = new Twitter($querySecond);

        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $venues = new BusyVenues($lat, $lng);

        $firstElement = array(
            'id' => $this->firstID,
            'query' => $queryFirst,
            'date' => $dateFirst,
            'lat' => $lat,
            'lng' => $lng,
        );
        $secondElement = array(
            'id' => $this->secondID,
            'query' => $querySecond,
            'date' => $dateSecond,
            'lat' => $lat,
            'lng' => $lng,
        );

        /**
         * sorting the array
         */
        $ven = $venues->getData(strtotime($dateFirst), 0, 20);

        $mergeQueries1 = array_merge($twitFirst->getData(strtotime($dateFirst), 0, 10), $ven);
        usort($mergeQueries1, array($this, 'date_compare'));

        $mergeQueries2 = array_merge($twitSecond->getData(strtotime($dateSecond), 0, 10), $ven);
        usort($mergeQueries2, array($this, 'date_compare'));

        $response = array(
            'responseFirst' => $mergeQueries1,
            'responseSecond' => $mergeQueries2,
            'elements' => array(
                'first' => $firstElement,
                'second' => $secondElement,
            )
        );
        return view('comparison.result')->with('data', $response);
    }
}