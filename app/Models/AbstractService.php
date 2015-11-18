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

    abstract protected function getPostData();

    abstract protected function getResponse();

    abstract protected function setResponse($data);

    abstract protected function setPostDataDate($date);

    abstract protected function dateToString($date);

    abstract public function getCount($queryDate);

    abstract public function getCountForRange($startDate, $endDate);

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
}