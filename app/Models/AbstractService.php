<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 14/11/2015
 * Time: 21:46
 */
namespace Urban\Models;

abstract class AbstractService
{

    protected $url;

    protected $query;

    protected $postData;

    protected $responseData;
    // Force Extending class to define this method
    abstract protected function getURL();

//    abstract protected function getPostData();

//    abstract protected function getResponse();

    abstract protected function setResponse($data);

    abstract protected function setPostDataDate($date);

    abstract protected function dateToString($date);

    abstract public function getCount($queryDate);

    //abstract public function getCountForRange($startDate, $endDate);

    abstract public function getData($queryDate, $start, $end);
    //abstract protected function prefixValue($prefix);

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
        //return array_slice($responseData['response']['serviceJson']['users'], 0, 20,true);
        return $responseData;
    }

    protected function getPostData()
    {
        return $this->postData;
    }

    public function getResponse()
    {
//        if(is_null($this->responseData))
//        {
//            // TODO - add default date to config file
//            $this->setPostDataDate(strtotime('2015-08-08'));
//            dd($this->sendRequest($this->getPostData()));
//            return $this->sendRequest($this->getPostData());
//        }
        return $this->responseData;
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
//        $this->setResponse($response);
//        return $this->getResponse();
        return $response;
    }
    protected function getRandomTimeOfDay($date)
    {
        $startdate = $date;
        $enddate = strtotime('+ 23 hours', $date);

        $randDate = rand($startdate, $enddate);

        return date('Y-m-d H:i', $randDate);
    }
}