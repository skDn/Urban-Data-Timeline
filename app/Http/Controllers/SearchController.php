<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 07/11/2015
 * Time: 23:17
 */

namespace Urban\Http\Controllers;

use Illuminate\Http\Request;
use Urban\Models\BusyVenues;
use Urban\Models\Twitter;
use Validator;

/**
 * Class SearchController
 * *********************DEPRECATED*******************
 * @package Urban\Http\Controllers
 */
class SearchController extends Controller
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
            'query' . $this->firstID => 'max:100|alpha_dash',
            'date' => 'required|date',
//            digits_between:min,max for lat/lng
            'lat' => 'required|regex:/^(\-?\d+(\.\d+)?).\s*(\-?\d+(\.\d+)?)$/',
            'lng' => 'required|regex:/^(\-?\d+(\.\d+)?).\s*(\-?\d+(\.\d+)?)$/',
        ];
    }

    public function getResults(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return redirect()->route('event')
                ->withErrors($validator)
                ->withInput();
        }

        $query = $request->input('query' . $this->firstID);
        $date = $request->input('date');
        if (!$query) {
            return redirect()->route('event');
        }

        $twit = new Twitter($query);

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $venues = new BusyVenues($lat, $lng);


        $firstElement = array(
            'id' => $this->firstID,
        );
        /**
         * sorting the array
         */
        $mergeQueries = array_merge($twit->getData(strtotime($date), 0, 10), $venues->getData(strtotime($date), 0, 20));
        usort($mergeQueries, array($this, 'date_compare'));

        $response = array(
            'elements' => array(
                'first' => $firstElement,
            ),
            'response' => $mergeQueries,
        );
        return view('search.result')->with('data', $response)->withInput($request->all());
    }
}