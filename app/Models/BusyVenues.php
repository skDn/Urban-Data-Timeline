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

    function __construct($lat, $lon)
    {

        $this->url = config('services.busyVenues.url');
        $this->postData = array(
            "request" => array(
                "lat" => $lat,
                "lon" => $lon,
                "radius" => config('controls.venuesRange'),
                "timestamp" => null,
            )
        );
//        $this->responseData = array(
//            "venues" => null,
//        );
        //$this->date = $d;
    }
    protected function getURL()
    {
        return $this->url;
    }

    protected function setResponse($data)
    {
        //$this->responseData['venues'] = $data;
        $this->responseData = $data;
    }

    protected function setPostDataDate($date)
    {
        $this->postData['request']['timestamp'] = $this->dateToString($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d 12:00:00",$date);
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
        $cmp_date1 = date("Y-m-d", $queryDate);

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
                $originalDate = $timeSeries['dateString'];
                $newDate = date("Y-m-d H:i", strtotime($originalDate));

                $venueInformation = array();
                // getting info for each venue
                foreach ($response['response']['results']['venuesData'] as $entryInfo) {
                    $originalDate = $timeSeries['dateString'];

                    $cmp_date2 = date("Y-m-d", strtotime($originalDate));

                    //dd($entryInfo);
                    if ($entryInfo['id'] == $venue['id'])
                    {
                        if ($cmp_date1 == $cmp_date2) {

                            $newDate = date("Y-m-d H:i", strtotime($originalDate));
                            array_push($modifiedData, array(
                                'class' => 'venue',
                                'venue' => $venue['displayName'],
                                'dateString' => $newDate,
                                'users' => $entryInfo['stats']['usersCount'],
                                'checkins' => $entryInfo['stats']['checkinsCount'],
                                'location' => $entryInfo['location']['country'],
                            ));
                            break;
                        }
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

    public function getVenueData ($queryDate) {
        $this->setPostDataDate($queryDate);
        //dd($this->getPostData());
        $post = $this->getPostData();
        /**
         * TODO - change this not to 0
         */
        // if searchtoken is venue
        $post['request']['radius'] = 0;
        // else radius is 0.5 or 1
        $response = $this->sendRequest($post);
//        dd($response);
        $cmp_date1 = date("Y-m-d", $queryDate);

        $venueTime = array_values($response['response']['results']['venueTimeSeries'])[0];
        $venueData = array_values($response['response']['results']['venuesData'])[0];

        $returnArr = array();
        foreach ($venueTime as $timeSeries) {
            $originalDate = $timeSeries['dateString'];

            $cmp_date2 = date("Y-m-d", strtotime($originalDate));
            //dd($cmp_date1 . " " .$cmp_date2);
            if ($cmp_date1 == $cmp_date2) {

                $newDate = date("Y-m-d H:i", strtotime($originalDate));
                array_push($returnArr, array(
                    'class' => 'venueTimeSeries',
                    'dateString' => $newDate,
                    'value' => $timeSeries['value'],
                    'name' => $venueData['name'],
                    'phone' => array_key_exists('formattedPhone',$venueData['contact'])? $venueData['contact']['formattedPhone'] : null,
                    'location' => array_key_exists('address',$venueData['location'])? $venueData['location']['address'] : null,
                    //'menuURL' => $venueData['menu']['url'],
                    //'twitter' => $venueData['contact']['twitter'],
                    'lat' => $venueData['location']['lat'],
                    'lng' => $venueData['location']['lng'],
                ));
            }
        }

        //dd($returnArr);
        return $returnArr;

    }

    public function getVenuesNearBy($radius)
    {
        /**
         * TODO - change this date to config date
         */
        $this->setPostDataDate(strtotime('2015-07-01'));
        //dd($this->getPostData());
        $post = $this->getPostData();
        $post['request']['radius'] = $radius;
        $response = $this->sendRequest($post);
        $venueData = array_values($response['response']['results']['venuesData']);
        $returnArr = array();
        foreach ($venueData as $venue) {
                //dd($venue);
                array_push($returnArr, array(
                    'name' => $venue['name'],
                    'phone' => array_key_exists('formattedPhone',$venue['contact'])? $venue['contact']['formattedPhone'] : null,
                    'location' => array_key_exists('address',$venue['location'])? $venue['location']['address'] : null,
                    'postalCode' => array_key_exists('postalCode',$venue['location'])? $venue['location']['postalCode'] : null,
                    'twitter' => array_key_exists('twitter',$venue['contact']) ? $venue['contact']['twitter'] : '',
                    'lat' => $venue['location']['lat'],
                    'lng' => $venue['location']['lng'],
                ));
            }
        return $returnArr;
    }
}
