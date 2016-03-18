<?php
//
//status when this property has the value "OK", it means that the request is successful and the results are valid. Otherwise, there is an error.
//trainStations is an array containing the train stations found. Each Object in the array represent a train station.
//
//The train station object in the trainStations array contains the following properties (Please consult the NaPTAN documentation for more details about some of these properties ):
//	atcoCode is the ATCO code of the station used by journey planners, e.g. "9100CHRNGXG"
//	crsCode is the Computer reservation system code of the station, e.g. "CHC"
//	stationName e.g. Charing Cross (Glasgow) Rail Station
//	stopLat the latitude of the station
//	stopLon the longitude of the station
//	tiplocCode the timing point location code. This is the key used in the delay services end point.
//
//{"request": {"lat": 55.8580 , "lon":-4.2590, "radius": 1.0}}

namespace Urban\Models;

class TrainStations extends AbstractService
{
    function __construct($lat, $lon, $date)
    {
        $this->queryDate = strtotime($date);
        $this->url = config('services.trainStations.url');
        $this->postData = array(
            "request" => array(
                "lat" => $lat,
                "lon" => $lon,
                "radius" => config('controls.stationsRange'),
            )
        );
        $this->response = $this->sendRequest($this->getPostData());
        $this->responseData = array(
            "trainStations" => null,
        );
    }

    public function getResponse()
    {
        // TODO: Implement getResponse() method.
    }

    protected function setResponse($data)
    {
        $this->responseData = $data;
    }

    protected function setPostDataDate($date)
    {
        // TODO: Implement setPostDataDate() method.
    }

    public function getCount()
    {
        $response = $this->getResponse();

        $count = 0;
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            foreach ($response['response']['trainStations'] as $trainStation) {

                $count++;
            }
        }
        $returnArray = array(
            'date' => $this->dateToString($this->queryDate),
            'count' => $count,
        );
        return $returnArray;
    }

    public function getCountForRange($startDate, $endDate)
    {
        // TODO: Implement getCountForRange() method.
    }

    public function getData()
    {
        $response = $this->getResponse();
        $returnArr = array();
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            foreach ($response['response']['trainStations'] as $trainStation) {
                array_push($returnArr, array(
                    'class' => "trainStation",
                    "stationName" => $trainStation['stationName'],
                    "lat" => $trainStation['stopLat'],
                    "lon" => $trainStation['stopLon'],
                    "tiploc" => $trainStation['tiplocCode'],
                ));
            }
        }
        return $returnArr;

    }

    protected function dateToString($date)
    {
        return date("Y-m-d H:i", strtotime($date));
    }
}