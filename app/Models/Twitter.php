<?php

namespace Urban\Models;

use Cache;

class Twitter extends AbstractService
{
//    private $responseData;

    function __construct($q, $date)
    {
        $this->query = $q;
        $this->queryDate = strtotime($date);
        $this->url = config('services.twitter.url');
        $this->postData = array(
            "request" => array(
                "query" => '#'.$this->query,
                "date" => $date,

            )
        );
        $this->response = $this->sendRequest($this->getPostData());
    }
    /**Getting how many tweets there were at a given day
     * @return array
     */
    public function getCount()
    {
        $response = $this->getResponse();

        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            return array(
                'date' => $response['response']['date'],
                'count' => $response['response']['serviceJson']['f_tweets']
            );
        }
        return null;

    }
    /**Getting data for specific query term
     * @return array
     */
    public function getData()
    {
        $response = $this->getResponse();
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $returnArr = array();
            foreach ($response['response']['serviceJson']['tweet'] as $arr) {
                $date = \DateTime::createFromFormat('jmY His', $arr['time']);
                array_push($returnArr, array(
                        'dateString' => $date->format('Y-m-d H:i' ),//$this->getRandomTimeOfDay($this->getQueryDate()),
                        'class' => 'tweet',
                        'screen_name' => $arr['screen_name'],
                        'text' => $arr['text'],
                        'image' => $arr['image']
                    ));
            }
            return $returnArr;
        }
        return null;
    }
    /**Getting information from the response to summarise the user's request
     * @return array
     */
    public function getInfo()
    {
        $response = $this->getResponse();
        if (isset($response['response']['status']) && $response['response']['status'] == 'OK') {
            $popularHTags = array_slice($response['response']['serviceJson']['hashtags'], 0, 5, true);
            array_shift($popularHTags);
            return array(
                "nTweets" => $response['response']['serviceJson']['f_tweets'],
                "popularHTags" => $popularHTags,
                "nTweetsForDay" => $response['response']['serviceJson']['tweets'],
                "nUsers" => $response['response']['serviceJson']['userSize'],
                "date" => $response['response']['date'],
                "query" => $response['response']['query']
            );
        }
        return null;
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
        $this->response['twitter'] = $data;
    }
}