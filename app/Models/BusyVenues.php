<?php

namespace Urban\Models;

use Cache;

class BusyVenues extends AbstractService
{

    const RADIUS = "radius";

    const RESPONSE = 'response';

    const STATUS = 'status';

    const RESULTS = 'results';



    const Y_M_D_H_I = "Y-m-d H:i";

    const VENUE_TIME_SERIES = 'venueTimeSeries';

    const ID = 'id';

    const VENUES_DATA = 'venuesData';

    const REQUEST = 'request';

    const LAT = 'lat';

    const LON = 'lon';

    const OK = 'OK';

    const CACHE_TAG_VENUE_DATA = 'venueData';

    const CACHE_TAG_VENUE_TIME = 'venueTimeSeries';

    const VENUE_CACHE_LIMIT = 15;

    function __construct($lat, $lon)
    {
        $this->url = config('services.busyVenues.url');
        $this->postData = array(
            self::REQUEST => array(
                self::LAT => $lat,
                self::LON => $lon,
                self::RADIUS => config('controls.venuesRange'),
                "timestamp" => null,
            )
        );
    }


    protected function setResponse($data)
    {
        $this->responseData = $data;
    }

    protected function setPostDataDate($date)
    {
        $this->postData[self::REQUEST]['timestamp'] = $this->dateToString($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d 12:00:00", $date);
    }

    public function getCount($queryDate, $resp)
    {
        // init request parameters
        $this->setPostDataDate($queryDate);
        // sending request
        $response = $this->sendRequest($this->getPostData());

        $count = 0;
        if (isset($response[self::RESPONSE][self::STATUS]) && $response[self::RESPONSE][self::STATUS] == self::OK) {
            foreach ($response[self::RESPONSE][self::RESULTS][self::RESULTS] as $venue) {
                if ($venue['score'] > 0.0) {
                    $count++;
                }
            }
        }
        return array(
            'date' => $this->dateToString($queryDate),
            'count' => $count,
        );
    }

    public function getData($queryDate, $resp, $start, $end)
    {
        $this->setPostDataDate($queryDate);
        $post = $this->getPostData();
        $cacheLat = $post[self::REQUEST][self::LAT];
        $cacheLon = $post[self::REQUEST][self::LON];
        $cacheTag = self::CACHE_TAG_VENUE_DATA; //config timeline twitter
        $cacheKey = $cacheTag . "-" . $cacheLat . "-" . $cacheLon . "-" . $queryDate;
        $cacheLimit = self::VENUE_CACHE_LIMIT;

//        if (Cache::has($cacheKey)) {
//            return Cache::get($cacheKey);
//        }

        $cmp_date1 = date(Y_M_D, $queryDate);

        $response = $this->sendRequest($post);
//        dd($response[self::RESPONSE][self::RESULTS][self::VENUE_TIME_SERIES]['4dd242367d8b4c6585e723c9']);
        $modifiedData = array();
        $filter = array();
        //TODO: implement infinite scrolling
        if (isset($response[self::RESPONSE][self::STATUS]) && $response[self::RESPONSE][self::STATUS] == self::OK) {
            foreach ($response[self::RESPONSE][self::RESULTS][self::RESULTS] as $venue) {
                if ($venue['score'] > 0.0) {
                    array_push($filter, $venue);
                }
            }
            foreach ($filter as $venue) {
                $timeSeries = array();
//                TODO: Service has a bug with score to value mapping
//                foreach($response['response']['results']['venueTimeSeries'][$venue['id']] as $timeSeriesIter)
//                {
//                    if($timeSeriesIter['value']>0.0)
//                    {
//                        array_push($timeSeries,$timeSeriesIter);
//                    }
//                }
                $randint = rand(0, count($response[self::RESPONSE][self::RESULTS][self::VENUE_TIME_SERIES][$venue[self::ID]]) - 1);
                // getting a random record from the time series
                $timeSeries = array_values($response[self::RESPONSE][self::RESULTS][self::VENUE_TIME_SERIES][$venue[self::ID]])[$randint];
                $originalDate = $timeSeries[KEY_DATE_STRING];
                $newDate = date(self::Y_M_D_H_I, strtotime($originalDate));

                $venueInformation = array();
                // getting info for each venue
                foreach ($response[self::RESPONSE][self::RESULTS][self::VENUES_DATA] as $entryInfo) {
                    $originalDate = $timeSeries[KEY_DATE_STRING];

                    $cmp_date2 = date(Y_M_D, strtotime($originalDate));

                    if ($entryInfo[self::ID] == $venue[self::ID]) {
                        if ($cmp_date1 == $cmp_date2) {

                            $newDate = date(self::Y_M_D_H_I, strtotime($originalDate));
                            array_push($modifiedData, array(
                                KEY_CLASS => KEY_VENUE,
                                KEY_VENUE => $venue['displayName'],
                                KEY_DATE_STRING => $newDate,
                                'users' => $entryInfo['stats']['usersCount'],
                                'checkins' => $entryInfo['stats']['checkinsCount'],
                                'location' => $entryInfo['location']['country'],
                            ));
                            break;
                        }
                    }
                }
            }
        }
//        following code returns the response in format 'venues' => array()
        if (count($modifiedData) > 0) {
            Cache::put($cacheKey, $modifiedData, $cacheLimit);
        }
        return $modifiedData;
    }

    public function getVenueData($queryDate)
    {
        $this->setPostDataDate($queryDate);
        $post = $this->getPostData();
        $cacheLat = $post[self::REQUEST][self::LAT];
        $cacheLon = $post[self::REQUEST][self::LON];
        $cacheTag = self::CACHE_TAG_VENUE_TIME; //config timeline twitter
        $cacheKey = $cacheTag . "-" . $cacheLat . "-" . $cacheLon . "-" . $queryDate;
        $cacheLimit = self::VENUE_CACHE_LIMIT;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        /**
         * TODO - change this not to 0
         */
        // if searchtoken is venue
        $post[self::REQUEST][self::RADIUS] = 0;
        // else radius is 0.5 or 1
        $response = $this->sendRequest($post);
        $cmp_date1 = date(Y_M_D, $queryDate);
        $venueTime = array_values($response[self::RESPONSE][self::RESULTS][self::VENUE_TIME_SERIES])[0];
        $venueData = array_values($response[self::RESPONSE][self::RESULTS][self::VENUES_DATA])[0];

        $returnArr = array();
        foreach ($venueTime as $timeSeries) {
            $originalDate = $timeSeries[KEY_DATE_STRING];

            $cmp_date2 = date(Y_M_D, strtotime($originalDate));
            if ($cmp_date1 == $cmp_date2) {

                $newDate = date(self::Y_M_D_H_I, strtotime($originalDate));
                array_push($returnArr, array(
                    KEY_CLASS => self::VENUE_TIME_SERIES,
                    KEY_DATE_STRING => $newDate,
                    'value' => $timeSeries['value'],
                    'name' => $venueData['name'],
                    'phone' => array_key_exists('formattedPhone', $venueData['contact']) ? $venueData['contact']['formattedPhone'] : null,
                    'location' => array_key_exists('address', $venueData['location']) ? $venueData['location']['address'] : null,
                    self::LAT => $venueData['location'][self::LAT],
                    'lng' => $venueData['location']['lng'],
                ));
            }
        }
        if (count($returnArr) > 0) {
            Cache::put($cacheKey, $returnArr, $cacheLimit);
        }
        return $returnArr;

    }

    public function getVenuesNearBy($radius)
    {
        /**
         * TODO - change this date to config date
         */
        $this->setPostDataDate(strtotime('2015-07-01'));
        $post = $this->getPostData();
        $post[self::REQUEST][self::RADIUS] = $radius;


        $response = $this->sendRequest($post);
        $venueData = array_values($response[self::RESPONSE][self::RESULTS][self::VENUES_DATA]);
        $returnArr = array();
        foreach ($venueData as $venue) {
            array_push($returnArr, array(
                'name' => $venue['name'],
                'phone' => array_key_exists('formattedPhone', $venue['contact']) ? $venue['contact']['formattedPhone'] : null,
                'location' => array_key_exists('address', $venue['location']) ? $venue['location']['address'] : null,
                'postalCode' => array_key_exists('postalCode', $venue['location']) ? $venue['location']['postalCode'] : null,
                'twitter' => array_key_exists('twitter', $venue['contact']) ? $venue['contact']['twitter'] : '',
                self::LAT => $venue['location'][self::LAT],
                'lng' => $venue['location']['lng'],
            ));
        }
        return $returnArr;
    }
}
