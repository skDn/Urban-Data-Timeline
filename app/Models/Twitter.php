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

    protected function getPostData()
    {
        return $this->postData;
    }
    protected function setPostDataDate($date)
    {
        $this->postData['request']['date'] = $this->dateToString($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d",$date);
    }

    public function getCountForRange($startDate, $endDate)
    {
        if ($startDate == $endDate)
        {
            $response = $this->getCount($startDate);
        }
        else {
            if ($startDate > $endDate) {
                $start = $endDate;
                $endDate = $startDate;
                $startDate = $start;
            }
            $response = array();
            while ($startDate <= $endDate) {
                array_push($response, $this->getCount($startDate));
                $startDate = strtotime('+1 days', $startDate);
            }
        }
        $this->setResponse($response);
        return $this->getResponse();
    }

    protected function getResponse()
    {
        return $this->responseData;
    }

    protected function setResponse($data)
    {
        $this->responseData['twitter'] = $data;
    }
}