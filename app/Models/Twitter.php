<?php

namespace Urban\Models;

//use Illuminate\Database\Eloquent\Model;
//use Urban\AbstractService as AbstractService;

class Twitter extends AbstractService
{
    function __construct($q)
    {
        $this->query = $q;
        $this->url = config('services.twitter.url');
        $this->postData = array(
            "request" => array(
                "query" => $this->query,
                "date" => null,
            )
        );
        $this->responseData = array(
            "twitter" => null,
        );
        //$this->date = $d;
    }
    protected function getURL()
    {
        return $this->url;
    }

    public function getCount($queryDate)
    {
        // init request parameters
        $this->setPostDataDate($queryDate);
        // sending request
        $response = $this->sendRequest($this->getPostData());

        $count = 0;
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $count = $response['response']['serviceJson']['userSize'];
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
        //TODO: implement infinite scrolling
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            return array_slice($response['response']['serviceJson']['users'], $start, $end, true);
        }
        return array();
    }
    protected function setPostDataDate($date)
    {
        $this->postData['request']['date'] = $this->dateToString($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d",$date);
    }

    protected function setResponse($data)
    {
        $this->responseData['twitter'] = $data;
    }
}