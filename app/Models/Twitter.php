<?php

namespace Urban\Models;

use Cache;

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
    }

    public function getCount($queryDate, $resp)
    {
        // init request parameters
        $this->setPostDataDate($queryDate);
        // sending request
        $response = ($resp) ? $resp : $this->sendRequest($this->getPostData());
        //$response = $this->sendRequest($this->getPostData());


        $count = 0;
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $count = $response['response']['serviceJson']['f_tweets'];
        }
        else {
            return null;
        }
        $returnArray = array(
            'date' => $this->dateToString($queryDate),
            'count' => $count,
        );

        return $returnArray;
    }

    public function getData($queryDate, $resp, $start, $end)
    {
        $this->setPostDataDate($queryDate);
        $postData = $this->getPostData();
        $cacheTag = 'twitterService'; //config timeline twitter
        $query = $postData['request']['query'];
        $cacheKey = $cacheTag . "-" . $query . "-" . $queryDate;
        $cacheLimit = 15;


//        if (Cache::has($cacheKey)) {
//            return Cache::get($cacheKey);
//        }

        $response = ($resp) ? $resp : $this->sendRequest($this->getPostData());
        //TODO: implement infinite scrolling
        $sliced = array();
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $sliced = array_slice($response['response']['serviceJson']['users'], $start, $end, true);
        }
        // creating the return array
        // adding random timestamp to each tweet
        $returnArr = array();
        if (count($sliced) > 0) {
            foreach ($sliced as $arr) {
                array_push($returnArr, $arr + array(
                        'dateString' => $this->getRandomTimeOfDay($queryDate),
                        'class' => 'tweet',
                    ));
            }
        }
        if (count($returnArr) > 0) {
            Cache::put($cacheKey, $returnArr, $cacheLimit);
        }
        return $returnArr;
    }

    public function getInfo($queryDate)
    {
        $this->setPostDataDate($queryDate);
        $response = $this->sendRequest($this->getPostData());
        $returnArr = array();
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $popularHTags = array_slice($response['response']['serviceJson']['hashtags'], 0, 5, true);
            array_shift($popularHTags);
            $returnArr = array(
                "nTweets" => $response['response']['serviceJson']['f_tweets'],
                "popularHTags" => $popularHTags,
                "nTweetsForDay" => $response['response']['serviceJson']['tweets'],
                "nUsers" => $response['response']['serviceJson']['userSize'],
                "date" => $response['response']['date'],
                "query" => $response['response']['query']
            );
        }
        return $returnArr;
    }

    protected function setPostDataDate($date)
    {
        $this->postData['request']['date'] = $this->dateToString($date);
    }

    protected function dateToString($date)
    {
        return date("Y-m-d", $date);
    }

    protected function setResponse($data)
    {
        $this->responseData['twitter'] = $data;
    }
}