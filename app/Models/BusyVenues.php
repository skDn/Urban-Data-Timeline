<?php

//The response object returned by this end point contains the following properties
//- status when this property has the value "OK", it means that the request is successful and the results are valid. Otherwise, there is an error.
//- results an array of reslut objects ordered by their score. Each object represent a place (FouSquare venue) and would contain the following properties:
//	- id the FourSquare ID of the venue
//- score the score of the venue in the ranked list
//    - displayName the display name of the venue
//- venuesTimeSeries a Json object which maps each venue ID in the results above to a time-series of historical and future checkins for the venue. The time-series is an array of JSON objects:
//	- timeInMilis a long value representing the standard epoch timestamp of the time point in the series
//- dateString a string representation of the time point in the series
//- value a number representing the attendance of the venue in the corresponding time series
//- venuesData an array of objects. Each contains information about the venues in the results. Full details about the fields in these objects can be obtaine here: https://developer.foursquare.com/docs/responses/venue
/* {request: {lat: 55.8748 , lon:-4.2929, radius:0.05, timestamp: "2015-07-01 14:00:00"}} */

namespace Urban\Models;

class BusyVenues extends AbstractService
{

    function __construct($q, $lat, $lon)
    {
        $this->query = $q;
        $this->url = config('services.busyVenues.url');
        $this->postData = array(
            "request" => array(
//                "query" => $this->query,
                "lat" => $lat,
                "lon" => $lon,
                "radius" => config('controls.venuesRange'),
                "timestamp" => null,
            )
        );
        $this->responseData = array(
            "venues" => null,
        );
        //$this->date = $d;
    }
    protected function getURL()
    {
        return $this->url;
    }

    protected function setResponse($data)
    {
        $this->responseData['venues'] = $data;
    }

    protected function setPostDataDate($date)
    {
        $this->postData['request']['timestamp'] = $this->dateToString($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d h:m:s",$date);
    }

    public function getCount($queryDate)
    {
        // init request parameters
        $this->setPostDataDate($queryDate);
        // sending request
        $response = $this->sendRequest($this->getPostData());

        $count = 0;
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            foreach ($response['response']['results']['results'] as $venue)
            {
                if ($venue['score'] > 0.0)
                {
                    $count++;
                }
            }
        }
        $returnArray = array(
            'date' => $this->dateToString($queryDate),
            'count' => $count,
        );

        return $returnArray;
    }

    public function getData($queryDate, $start, $end)
    {
        $this->setPostDataDate($queryDate);

        $response = $this->sendRequest($this->getPostData());
        //dd($response['response']['results']);
        $modifiedData = array();
        $filter = array();
        //TODO: implement infinite scrolling
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            foreach ($response['response']['results']['results'] as $venue)
                {
                    if ($venue['score'] > 0.0)
                    {
                        array_push($filter, $venue);
                    }
                }
            foreach($filter as $venue)
            {
                $timeSeries = array();
//                TODO: Service has a bug with score to value mapping
//                foreach($response['response']['results']['venueTimeSeries'][$venue['id']] as $timeSeriesIter)
//                {
//                    if($timeSeriesIter['value']>0.0)
//                    {
//                        array_push($timeSeries,$timeSeriesIter);
//                    }
//                }
                $randint = rand(0 , count($response['response']['results']['venueTimeSeries'][$venue['id']])-1);
                //dd($response['response']['results']['venueTimeSeries'][$venue['id']]);
                // getting a random record from the time series
                $timeSeries = array_values($response['response']['results']['venueTimeSeries'][$venue['id']])[$randint];
                //dd($timeSeries);
                $venueInformation = array();
                // getting info for each venue
                foreach ($response['response']['results']['venuesData'] as $entryInfo) {
                    //dd($entryInfo);
                    if ($entryInfo['id'] == $venue['id'])
                    {
                        array_push($modifiedData,array(
                            'class' => 'venue',
                            'venue' => $venue['displayName'],
                            'dateString' => $timeSeries['dateString'],
                            'venueInfo' => $entryInfo,
                        ));
                        break;
                    }
                }


            }
            //return array_slice($response['response']['serviceJson']['users'], $start, $end, true);
        }
//        following code returns the response in format 'venues' => array()
//        $this->setResponse($modifiedData);
//        return $this->getResponse();

        return $modifiedData;
    }
}
