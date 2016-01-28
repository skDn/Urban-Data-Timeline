<?php

//{"request":{"tiploc":"GLGQHL","shortDate":"2015-04-01","minimumDelay":"5"}}

namespace Urban\Models;

class DelayedServices extends AbstractService
{

    function __construct($date)
    {

        $this->url = config('services.delayedServices.url');
        $this->postData = array(
            "request" => array(
                "minDelay" => config('controls.delayedServicesMinDelay'),
                "shortDate" => date("Y-m-d", strtotime($date)),
                "tiploc" => null,
            )
        );
//        $this->responseData = array(
//            "venues" => null,
//        );
        //$this->date = $d;
    }

    public function getResponse()
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

    }
    public function getDate($tiploc)
    {

        $this->postData['request']['tiploc'] = $tiploc;
        $response = $this->sendRequest($this->getPostData());
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $response = json_decode($response['response']['jsonResponse'],TRUE);
            dd(array_values($response)[0]);
        }

    }
}