<?php

namespace Urban;

//use Illuminate\Database\Eloquent\Model;

class Twitter
{
    protected $query;

    protected $date;

    protected $response;

    function __construct($q)
    {
        $this->query = $q;
        //$this->date = $d;
    }

    function getQuery()
    {
        return $this->query;
    }

    function getNumberOfTweetsForDay($specDate)
    {
        if (is_null($this->response) || strcmp($this->response['response']['date'], $specDate) !== 0)
            $this->response = $this->sendRequest($this->query, $specDate);
        $returnArray = array(
            'date' => $this->response['response']['date'],
            'count' => $this->response['response']['serviceJson']['userSize'],
        );
        return json_encode($returnArray);
    }

    function getUsers($specDate)
    {
        if (is_null($this->response) || strcmp($this->response['response']['date'], $specDate) !== 0)
            $this->response = $this->sendRequest($this->query, $specDate);
        //TODO: implement infinite scrolling
        return array_slice($this->response['response']['serviceJson']['users'], 0, 20, true);
    }
    //TODO: refactor
    protected function sendRequest($q, $d)
    {
        $postData = array(
            "request" => array(
                "query" => $q,
                "date" => $d,
            )
        );
        $ch = curl_init('http://localhost:8080/ubdc-web/getTweetStats.action');
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
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