<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 14/11/2015
 * Time: 21:46
 */
namespace Urban\Models;


/**
 * const storing the array key for class
 */
const KEY_CLASS = 'class';

/**
 * const storing the class of a venue
 */
const KEY_VENUE = 'venue';

/**
 * const storing the array key for the date.
 */
const KEY_DATE_STRING = 'dateString';

/**
 * const storing the expression that will convert a string
 * to specific format.
 */
const Y_M_D = "Y-m-d";

/**
 * Class AbstractService
 * @package Urban\Models
 */
abstract class AbstractService
{

    /** holds the service url
     * @var String
     */
    protected $url;

    /** holds the input query
     * @var String
     */
    protected $query;

    /** holds the request parameters
     * @var array
     */
    protected $postData;

    /** holds the input date
     * @var int
     */
    public $queryDate;

    /** holds the response from the services
     * @var array
     */
    public $response;


    /**
     * @param $data
     * @return mixed
     */
    abstract protected function setResponse($data);

    /**
     * @param $date
     * @return mixed
     */
    abstract protected function setPostDataDate($date);

    /**
     * @param $date
     * @return mixed
     */
    abstract protected function dateToString($date);

    /**
     * @return array
     */
    abstract public function getCount();

    /**
     * @return array
     */
    abstract public function getData();


    // Common method
    /**
     * @param $arrayToSend
     * @return mixed|string
     */
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

    /**
     * @return mixed
     */
    protected function getPostData()
    {
        return $this->postData;
    }


    /**
     * @param $startDate
     * @param $endDate
     * @return array|mixed
     */
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

    /**
     * @param $date
     * @return bool|string
     */
    protected function getRandomTimeOfDay($date)
    {
        $startDate = $date;
        $endDate = strtotime('+ 23 hours', $date);

        $randDate = rand($startDate, $endDate);

        return date('Y-m-d H:i', $randDate);
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    protected function getURL()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getQueryDate()
    {
        return $this->queryDate;
    }

    /**
     * @param $date
     */
    public function setQueryDate($date)
    {
        $this->queryDate = $date;
    }

}