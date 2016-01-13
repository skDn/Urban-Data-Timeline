<?php
/**
 * Created by IntelliJ IDEA.
 * User: yordanyordanov
 * Date: 16/12/2015
 * Time: 12:32
 */

namespace Urban\Models;


//define("DATEASID",     "M-d-hA");
define("DATEASID",     "ha");
define("DATEASCONTENT",     "Y-m-d h:i");
define("USEDIFF" , false);

use Cache;


use Thujohn\Twitter\Facades\Twitter;
use \DateTime as DateTime;

class TwitterTimeline extends AbstractService
{
    function __construct($q)
    {
        // getting username
        $this->query = $q;
//        $this->url = config('services.twitter.url');
//        $this->postData = array(
//            "request" => array(
//                "query" => $this->query,
//                "date" => null,
//            )
//        );
        $this->responseData = array(
            "twitterTimeline" => array(),
        );
        //$this->date = $d;
    }

    protected function getURL()
    {
        // TODO: Implement getURL() method.
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
        $tweets = $this->sendRequest($this->query);
        return count($tweets);
    }

    public function getData($queryDate, $start, $end)
    {
        // TODO:  queryDate is not used. Convert everyting to DateTime
        $qDate = new DateTime(date(DATEASCONTENT,$queryDate));


        $tweets = $this->sendRequest($this->query);

        foreach ($tweets as $tweet) {

            $date = new DateTime($tweet->created_at);
            $interval = $qDate->diff($date);
            $date = $date->sub(new \DateInterval($interval->format('P%aD')));
            //$date = $date->sub(new DateInterval($interval->format('%R%a days'));
            //dd($date);

            $tweet = array(
                'class' => 'tweetFromTimeline',
                'name' => $tweet->user->name,
                'screen_name' => $tweet->user->screen_name,
                'text' => Twitter::linkify($tweet->text),
                'dateString' => $date->format(DATEASCONTENT),
                /* trying to smooth the distance between two events */
                'diff' => null,
                'original' => Twitter::linkTweet($tweet),
            );
            array_push($this->responseData['twitterTimeline'], $tweet);
        }
        //dd($this->responseData);
        return $this->responseData['twitterTimeline'];
    }

    public function sendRequest ($username) {
        $user = $username;
        $cacheTag = 'twitterTimeline'; //config timeline twitter
        $cacheKey = $user."-".$cacheTag;
        $cacheLimit = 15;
        $tweets = null;

        /* caching */

        // $john = Cache::tags(['people', 'artists'])->get('John');
        if (Cache::has($cacheKey)) {
            $tweets = Cache::get($cacheKey);
        }
        else {
            $tweets = Twitter::getUserTimeline(['screen_name' => $user, 'count' => 10, 'format' => 'object']);
            Cache::put($cacheKey, $tweets, $cacheLimit);
        }
        return $tweets;
    }
}