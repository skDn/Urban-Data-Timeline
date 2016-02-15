<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 22/11/2015
 * Time: 21:50
 */

namespace Urban\Http\Controllers;

use DateTime as DateTime;
use Illuminate\Http\Request;
use Urban\Http\Middleware\SearchHelper;
use Validator;

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
            'query' . $this->firstID => 'required|max:100|alpha_dash',
            'query' . $this->secondID => 'required|max:100|alpha_dash',
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
            return redirect()->route('comparison')
                ->withErrors($validator)
                ->withInput();
        }


        $response = $this->prepareDataForView($request);
        return view('comparison.result')->with('comparisonData', $response);
    }

    private function prepareDataForView($request)
    {
        $queryFirst = $request->input('query' . $this->firstID);
        $querySecond = $request->input('query' . $this->secondID);

        $dateFirst = $dateSecond = $request->input('date');

        $lat = $request->input('lat');
        $lng = $request->input('lng');

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

        $helper = new SearchHelper();
        $mergeQueries1 = $helper->getResultsForEvent($queryFirst, $request);
        $mergeQueries2 = $helper->getResultsForEvent($querySecond, $request);

        foreach ($mergeQueries1['sections'] as $element1) {
            if (!$this->containsSectionWithId($mergeQueries2['sections'], $element1['id'])) {
                $point = $this->findPosition($mergeQueries2['sections'], $element1['id']);
                $sectionToAdd = array(array(
                    'id' => $element1['id'],
                    'events' => array(),
                ));
                array_splice($mergeQueries2['sections'], $point, 0, $sectionToAdd);
            }
        }
        foreach ($mergeQueries2['sections'] as $element2) {
            if (!$this->containsSectionWithId($mergeQueries1['sections'], $element2['id'])) {
                $point = $this->findPosition($mergeQueries1['sections'], $element2['id']);
                $sectionToAdd = array(array(
                    'id' => $element2['id'],
                    'events' => array(),
                ));
                array_splice($mergeQueries1['sections'], $point, 0, $sectionToAdd);
            }
        }

        $response = array(
            'responseFirst' => $mergeQueries1,
            'responseSecond' => $mergeQueries2,
            'elements' => array(
                'first' => $firstElement,
                'second' => $secondElement,
            )
        );
        //dd($response);
        return $response;

    }

    private function containsSectionWithId($array, $id)
    {
        foreach ($array as $arrayElement) {
            if ($arrayElement['id'] === $id) {
                return true;
            }
        }
        return false;
    }

    private function findPosition($array, $id)
    {
        $d1 = new DateTime($id);
        $pointer = 0;
        foreach ($array as $arrayElement) {
            $d2 = new DateTime($arrayElement['id']);
            if ($d2 < $d1) {
                $pointer++;
            }
            else {
                break;
            }
        }
        return $pointer;

    }

}