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

    protected function getURL()
    {
        // TODO: Implement getURL() method.
    }

    protected function getPostData()
    {
        // TODO: Implement getPostData() method.
    }

    protected function getResponse()
    {
        // TODO: Implement getResponse() method.
    }

    protected function setResponse($data)
    {
        // TODO: Implement setResponse() method.
    }

    protected function setPostDataDate($date)
    {
        // TODO: Implement setPostDataDate() method.
    }

    protected function dateToString($date)
    {
        // TODO: Implement dateToString() method.
    }

    public function getCount($queryDate)
    {
        // TODO: Implement getCount() method.
    }

    public function getCountForRange($startDate, $endDate)
    {
        // TODO: Implement getCountForRange() method.
    }

    public function getData($queryDate, $start, $end)
    {
        // TODO: Implement getData() method.
    }
}
