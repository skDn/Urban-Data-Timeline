<?php
use Urban\Models\Twitter;

/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 14/02/2016
 * Time: 11:47
 */
const RESPONSE = array(
    'response' => array(
        "date" => "2014-08-28",
        "query" => "noscotland",
        "serviceJson" => array(
            "users" => array(
                array(
                    "count" => 1,
                    "screen_name" => "aboutshawlands"
                )
            ),
            "tweet" => array(
                array(
                    "docno" => "504765739505815553",
                    "time" => "28082014 120145",
                    "text" => "RT @wattcommunity: FIFA to Scottish national football team in event of No vote | #indyref #YesScotland #noscotland #lol http://t.co/xxFhqOC…",
                    "score" => "",
                    "image" => "",
                    "screen_name" => ""
                )
            ),
            "userSize" => 12,
            "tokens" => 7406,
            "f_tweets" => 12,
            "hashtags" => array(
                array(
                    "count" => 12,
                    "hashtag" => "noscotland"
                )
            ),
            "tweets" => 99925,
            "locationSize" => 0,
            "all_user" => 45408
        ),
        "status" => "OK"
    )
);

class TwitterTest extends TestCase
{
    private $_mockedService;
    private $_object;


//    protected function setUp()
//    {
//        //$this->_mockedService = $this->getMock('Twitter');
//        //$this->_object = $this->getMock('Twitter', array('sendRequest', 'getCount')); //
//        //$this->_object = new Twitter($this->_mockedService);
//        //$this->_object = new Twitter('mock');
//    }

//    public function testGetRequestMocking()
//    {
//        $this->_object->expects($this->any())->method('sendRequest')->will($this->returnValue(10));
//        $this->assertEquals(10, $this->_object->sendRequest());
//    }

    public function testGetCount()
    {
        //$this->_object->expects($this->any())->method('sendRequest')->will($this->returnValue(RESPONSE));

//        $this->client->get('/event/search/count', ['date' => '2014-08-28', 'query' => 'noscotland',
//            'lat' => 55.858, 'lng' => -4.2590000000000146])
//            ->seeJson([
//                'noscotland' => true,
//            ]);
//        $this->_object = $this->getMockBuilder('Urban\Models\Twitter')->disableOriginalConstructor()->getMock();
//        $this->_object->expects($this->any())->method('sendRequest')->will($this->returnValue(RESPONSE));

        $help = new Twitter('mock');
        $twitterCount = $help->getCount(31232132132131, RESPONSE);

        $this->assertTrue(array_key_exists('date', $twitterCount));
        $this->assertTrue(array_key_exists('count', $twitterCount));
        $this->assertEquals(12, $twitterCount['count']);
    }

    public function testGetData()
    {
        $help = new Twitter('mock');

        $twitterData = $help->getData(321313, RESPONSE, 0, 15);

        $this->assertEquals(1, count($twitterData));

        $dataEntry = array_values($twitterData)[0];

        $this->assertTrue(array_key_exists('screen_name', $dataEntry));
        $this->assertTrue(array_key_exists('count', $dataEntry));
        $this->assertTrue(array_key_exists('class', $dataEntry));
        $this->assertTrue(array_key_exists('dateString', $dataEntry));

        $this->assertEquals('tweet', $dataEntry['class']);
        $this->assertEquals('aboutshawlands', $dataEntry['screen_name']);
    }
}
