<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 14/02/2016
 * Time: 11:47
 */
class TwitterTest extends TestCase
{
    /**
     *
     */
    const RESPONSE_VALID = array(
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
                        "text" => "RT @wattcommunity: FIFA to Scottish national football team in event of No vote | #indyref #YesScotland #noscotland #lol http://t.co/xxFhqOC�",
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

    /**
     *
     */
    const RESPONSE_INVALID = array(
        'response' => array(
            "date" => "2014-08-28",
            "query" => "noscotland",
            "serviceJson" => array(),
            "status" => "BAD"
        )
    );

    /**
     * @var \Urban\Models\Twitter mock
     */
    private $_mockedService = null;

    /**
     *
     */
    public function setUp()
    {
        $this->_mockedService = $this->getMockBuilder('Urban\Models\Twitter')
            ->setMethods(array('__construct'))
            ->setConstructorArgs(array('testQuery', 'testDate'))
            ->disableOriginalConstructor()
            ->getMock();

        $this->_mockedService->response = self::RESPONSE_VALID;
        $this->_mockedService->queryDate = 123456678;
    }

    /**
     *
     */
    public function tearDown()
    {
        unset($this->_mockedService);
    }


    /**
     *
     */
    public function testResponseData()
    {
        $result = $this->_mockedService->getResponse();

        $this->assertEquals(
            self::RESPONSE_VALID,
            $result
        );

    }

    /**
     *
     */
    public function testDate()
    {
        $result = $this->_mockedService->getQueryDate();

        $this->assertEquals(
            123456678,
            $result
        );

    }


    /**
     *
     */
    public function testGetCount()
    {
        $twitterCount = $this->_mockedService->getCount();

        $this->assertTrue(array_key_exists('date', $twitterCount));
        $this->assertTrue(array_key_exists('count', $twitterCount));
        $this->assertEquals(12, $twitterCount['count']);
    }

    /**
     *
     */
    public function testGetData()
    {

        $twitterData = $this->_mockedService->getData();

        $this->assertEquals(1, count($twitterData));

        $dataEntry = array_values($twitterData)[0];

        $this->assertTrue(array_key_exists('screen_name', $dataEntry));
        $this->assertTrue(array_key_exists('count', $dataEntry));
        $this->assertTrue(array_key_exists('class', $dataEntry));
        $this->assertTrue(array_key_exists('dateString', $dataEntry));

        $this->assertEquals('tweet', $dataEntry['class']);
        $this->assertEquals('aboutshawlands', $dataEntry['screen_name']);
    }

    /**
     *
     */
    public function testGetDataWithInvalidResponse()
    {
        $this->_mockedService->response = self::RESPONSE_INVALID;

        $twitterData = $this->_mockedService->getData();

        $this->assertNull($twitterData);

    }

    /**
     *
     */
    public function testGetInfo()
    {
        $this->_mockedService->response = self::RESPONSE_VALID;

        $twitterData = $this->_mockedService->getInfo();

        $this->assertNotNull($twitterData);

        $this->assertEquals(12, $twitterData['nTweets']);
        $this->assertEquals(99925, $twitterData['nTweetsForDay']);
        $this->assertEquals(12, $twitterData['nUsers']);
        $this->assertEquals("2014-08-28", $twitterData['date']);
        $this->assertEquals("noscotland", $twitterData['query']);
    }

}
