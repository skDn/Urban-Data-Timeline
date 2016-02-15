<?php

namespace Urban\Models;

class DelaysTimeSeries extends AbstractService
{

    function __construct($date)
    {

        $this->url = config('services.delaysTimeSeries.url');
        $this->postData = array(
            "request" => array(
                "minimumDelay" => config('controls.delayedServicesMinDelay'),
                "shortDate" => date("Y-m-d", strtotime($date)),
                "tiploc" => null,
            )
        );
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

    public function getCount($queryDate, $resp)
    {
        // TODO: Implement getCount() method.
    }

    public function getCountForRange($startDate, $endDate)
    {
        // TODO: Implement getCountForRange() method.
    }

    public function getData($queryDate, $resp, $start, $end)
    {

    }

    public function getDate($tiploc, $resp)
    {

        $this->postData['request']['tiploc'] = $tiploc;
        $response = $this->sendRequest($this->getPostData());
//        dd($this->getPostData());
//        dd($response);
        $returnArr = null;
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $returnArr = array();
            $cmpDate1 = $this->getPostData()['request']['shortDate'];
            foreach ($response['response']['ts']['timeseries'] as $timeSeries) {
                $cmpDate2 = date(Y_M_D, strtotime($timeSeries[KEY_DATE_STRING]));
                if ($cmpDate1 == $cmpDate2) {
                    array_push($returnArr, $timeSeries);
                }
            }
        }
        return $returnArr;

    }
}