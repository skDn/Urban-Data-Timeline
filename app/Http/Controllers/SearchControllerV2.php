<?php
/**
 * Created by IntelliJ IDEA.
 * User: yordanyordanov
 * Date: 16/12/2015
 * Time: 13:04
 */

namespace Urban\Http\Controllers;


use Illuminate\Http\Request;
use Urban\Http\Middleware\SearchHelper;
use Validator;

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
            'query' . $this->firstID => 'max:100|alpha_dash',
            'date' => 'required|date',
//            digits_between:min,max for lat/lng
            'lat' => 'required',
            'lng' => 'required',
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

        $helper = new SearchHelper();
        $response = $helper->getResultsForEvent($query, $request);

        $firstElement = array(
            'id' => $this->firstID,
        );

        $responseToView = array(
            'elements' => array(
                'first' => $firstElement,
            ),
            'sections' => $response['sections'],
            'info' => $response['info'],
        );
        return view('search.resultV2')->with('data', $responseToView)->withInput($request->all());
    }
}