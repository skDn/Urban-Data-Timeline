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

    const LOCATION = 'location';

    const PHONE = 'phone';

    const NAME = 'name';

    const VALUE = 'value';

    const FORMATTED_PHONE = 'formattedPhone';

    const CONTACT = 'contact';

    const ADDRESS = 'address';

    const LNG = 'lng';

    const POSTAL_CODE = 'postalCode';

    const TWITTER = 'twitter';

    function __construct($lat, $lon, $date, $radius)
    {
        $this->url = config('services.busyVenues.url');
        $this->queryDate = strtotime($date); // strtotime
        $this->postData = array(
            self::REQUEST => array(
                self::LAT => $lat,
                self::LON => $lon,
                self::RADIUS => ($radius) ? $radius : config('controls.venuesRange'),
                "timestamp" => $this->dateToString($this->queryDate),
            )
        );
        $this->response = $this->sendRequest($this->postData);
    }


    protected function setResponse($data)
    {
        $this->responseData = $data;
    }

    protected function setPostDataDate($date)
    {
        $this->postData[self::REQUEST]['timestamp'] = $this->dateToString($date);
        $this->setQueryDate($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d 12:00:00", $date);
    }

    /** Getting how many busy venues are around the area
     * @return array
     */
    public function getCount()
    {
        $response = $this->getResponse();

        $count = 0;
        if (isset($response[self::RESPONSE][self::STATUS]) && $response[self::RESPONSE][self::STATUS] == self::OK) {
            foreach ($response[self::RESPONSE][self::RESULTS][self::RESULTS] as $venue) {
                if ($venue['score'] > 0.0) {
                    $count++;
                }
            }
        }
        return array(
            'date' => date(Y_M_D, $this->getQueryDate()),
            'count' => $count,
        );
    }

    /**Getting data for busy venues in an area
     * @return array
     */
    public function getData()
    {
        /**
         * comment this out if using cache
         */
//        $this->setPostDataDate($this->getQueryDate());
//        $post = $this->getPostData();
//        $cacheLat = $post[self::REQUEST][self::LAT];
//        $cacheLon = $post[self::REQUEST][self::LON];
//        $cacheTag = self::CACHE_TAG_VENUE_DATA; //config timeline twitter
//        $cacheKey = $cacheTag . "-" . $cacheLat . "-" . $cacheLon . "-" . $this->getQueryDate();
//        $cacheLimit = self::VENUE_CACHE_LIMIT;

//        if (Cache::has($cacheKey)) {
//            return Cache::get($cacheKey);
//        }

        $cmp_date1 = date(Y_M_D, $this->getQueryDate());

        $response = $this->getResponse();
        $modifiedData = array();
        $filter = array();
        if (isset($response[self::RESPONSE][self::STATUS]) && $response[self::RESPONSE][self::STATUS] == self::OK) {
            foreach ($response[self::RESPONSE][self::RESULTS][self::RESULTS] as $venue) {
                if ($venue['score'] > 0.0) {
                    array_push($filter, $venue);
                }
            }

            foreach ($filter as $venue) {
                $fullTimeSeries = array();
                $maxValue = 0;
                $maxTimeSeries = null;
                // getting venues from the response only for the desired date
                foreach ($response[self::RESPONSE][self::RESULTS][self::VENUE_TIME_SERIES][$venue[self::ID]] as $timeSeriesIter) {
                    if ($timeSeriesIter[self::VALUE] > 0.0 && date(Y_M_D, strtotime($timeSeriesIter['dateString'])) === $cmp_date1) {
                        if ($maxValue < $timeSeriesIter[self::VALUE]) {
                            $maxValue = $timeSeriesIter[self::VALUE];
                            $maxTimeSeries = $timeSeriesIter;
                        }
                    }
                }
                // if max value of a venue for the day is found, add it to the list of busy venues
                if (!is_null($maxTimeSeries)) {
                    array_push($fullTimeSeries, $maxTimeSeries);
                }

                foreach ($fullTimeSeries as $timeSeries) {
                    $originalDate = $timeSeries[KEY_DATE_STRING];
                    // getting info for each venue
                    // needs refactoring as loops though the array more than once to find the venue info
                    foreach ($response[self::RESPONSE][self::RESULTS][self::VENUES_DATA] as $entryInfo) {//
                        if ($entryInfo[self::ID] == $venue[self::ID]) {
                            $newDate = date(self::Y_M_D_H_I, strtotime($originalDate));
                            array_push($modifiedData, array(
                                KEY_CLASS => KEY_VENUE,
                                KEY_VENUE => $venue['displayName'],
                                KEY_DATE_STRING => $newDate,
                                'users' => $entryInfo['stats']['usersCount'],
                                'checkins' => $entryInfo['stats']['checkinsCount'],
                                self::LOCATION => $entryInfo[self::LOCATION]['country'],
                            ));
                            break;
                        }
                    }
                }
            }
        }
//        following code returns the response in format 'venues' => array()
//        if (count($modifiedData) > 0) {
//            Cache::put($cacheKey, $modifiedData, $cacheLimit);
//        }
        return $modifiedData;
    }

    /** Getting venue data for specific date. Used for VenueTimeseries feature
     * @param $queryDate
     * @return array
     */
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
                    self::VALUE => $timeSeries[self::VALUE],
                    self::NAME => $venueData[self::NAME],
                    self::PHONE => array_key_exists(self::FORMATTED_PHONE, $venueData[self::CONTACT]) ? $venueData[self::CONTACT][self::FORMATTED_PHONE] : null,
                    self::LOCATION => array_key_exists(self::ADDRESS, $venueData[self::LOCATION]) ? $venueData[self::LOCATION][self::ADDRESS] : null,
                    self::LAT => $venueData[self::LOCATION][self::LAT],
                    self::LNG => $venueData[self::LOCATION][self::LNG],
                ));
            }
        }
        if (count($returnArr) > 0) {
            Cache::put($cacheKey, $returnArr, $cacheLimit);
        }
        return $returnArr;

    }

    /**Method that gets the venues near a specific location
     * @return array
     */
    public function getVenuesNearBy()
    {
        $response = $this->getResponse();
        $venueData = array_values($response[self::RESPONSE][self::RESULTS][self::VENUES_DATA]);
        $returnArr = array();
        foreach ($venueData as $venue) {
            array_push($returnArr, array(
                self::NAME => $venue[self::NAME],
                self::PHONE => array_key_exists(self::FORMATTED_PHONE, $venue[self::CONTACT]) ? $venue[self::CONTACT][self::FORMATTED_PHONE] : null,
                self::LOCATION => array_key_exists(self::ADDRESS, $venue[self::LOCATION]) ? $venue[self::LOCATION][self::ADDRESS] : null,
                self::POSTAL_CODE => array_key_exists(self::POSTAL_CODE, $venue[self::LOCATION]) ? $venue[self::LOCATION][self::POSTAL_CODE] : null,
                self::TWITTER => array_key_exists(self::TWITTER, $venue[self::CONTACT]) ? $venue[self::CONTACT][self::TWITTER] : '',
                self::LAT => $venue[self::LOCATION][self::LAT],
                self::LNG => $venue[self::LOCATION][self::LNG],
            ));
        }
        return $returnArr;
    }
}
