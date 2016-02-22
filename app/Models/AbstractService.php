<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 14/11/2015
 * Time: 21:46
 */
namespace Urban\Models;


const KEY_CLASS = 'class';

const KEY_VENUE = 'venue';

const KEY_DATE_STRING = 'dateString';

const Y_M_D = "Y-m-d";

abstract class AbstractService
{

    protected $url;

    protected $query;

    protected $postData;

    public $queryDate;

    public $response;

    public function getResponse()
    {
        return $this->response;
    }

    protected function getURL()
    {
        return $this->url;
    }

    public function getQueryDate ()
    {
        return $this->queryDate;
    }

    public function setQueryDate($date) {
        $this->queryDate = $date;
    }

    abstract protected function setResponse($data);

    abstract protected function setPostDataDate($date);

    abstract protected function dateToString($date);

    abstract public function getCount();

    abstract public function getData();

    // Common method
    public function sendRequest($arrayToSend)
    {

        $ch = curl_init($this->getURL());
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($arrayToSend)
        ));

        // Send the request
        $response = curl_exec($ch);
        if ($response === FALSE) {
            return curl_error($ch);
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);
        return $responseData;
    }

    protected function getPostData()
    {
        return $this->postData;
    }



    public function getCountForRange($startDate, $endDate)
    {
        if ($startDate == $endDate) {
            $response = $this->getCount();
        } else {
            if ($startDate > $endDate) {
                $start = $endDate;
                $endDate = $startDate;
                $startDate = $start;
            }
            $response = array();
            while ($startDate <= $endDate) {
                $this->setPostDataDate($startDate);
                $this->response = $this->sendRequest($this->getPostData());
                array_push($response, $this->getCount());
                $startDate = strtotime('+1 days', $startDate);
            }
        }
        return $response;
    }

    protected function getRandomTimeOfDay($date)
    {
        $startDate = $date;
        $endDate = strtotime('+ 23 hours', $date);

        $randDate = rand($startDate, $endDate);

        return date('Y-m-d H:i', $randDate);
    }
}