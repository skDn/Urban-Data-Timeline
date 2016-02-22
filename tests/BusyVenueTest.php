<?php

/**
 * Created by PhpStorm.
 * User: skDn
 * Date: 21/02/2016
 * Time: 17:17
 */
class BusyVenueTest extends TestCase
{
    /**
     *
     */
    const RESPONSE_VALID = array(
        "response" => array(
            "results" => array(
                "results" => array(
                    array(
                        "id" => "4ca1f8f3604c76b08d27a17b",
                        "score" => 1,
                        "displayName" => "Gregory Building - College Academic Building"
                    )
                ),
                "venueTimeSeries" => array(
                    "4ca1f8f3604c76b08d27a17b" => array(
                        array(
                            "timeInMilis" => 1435712400000,
                            "dateString" => "2015-07-01 02:00:00",
                            "value" => 0
                        ),
                        array("timeInMilis" => 1435712400000,
                            "dateString" => "2015-07-01 03:00:00",
                            "value" => 0),
                        array("timeInMilis" => 1435712400000,
                            "dateString" => "2015-07-01 04:00:00",
                            "value" => 0),
                    )
                ),
                "venuesData" => array(
                    array(
                        "_id" => array(
                            "_time" => 1441741018,
                            "_machine" => -458227045,
                            "_inc" => -1810979296,
                            "_new" => false
                        ),
                        "id" => "4ca1f8f3604c76b08d27a17b",
                        "name" => "Gregory Building",
                        "contact" => array(),
                        "location" => array(
                            "address" => "Glasgow University",
                            "crossStreet" => "Ashton Ln",
                            "lat" => 55.874239,
                            "lng" => -4.292427,
                            "postalCode" => "G12 8",
                            "cc" => "GB",
                            "city" => "Glasgow",
                            "state" => "Glasgow City",
                            "country" => "United Kingdom"
                        ),
                        "categories" => array(
                            array(
                                "id" => "4bf58dd8d48988d198941735",
                                "name" => "College Academic Building",
                                "pluralName" => "College Academic Buildings",
                                "shortName" => "Academic Building",
                                "icon" => array(
                                    "prefix" => "https=>//ss1.4sqi.net/img/categories_v2/education/academicbuilding_",
                                    "suffix" => ".png"
                                ),
                                "primary" => true
                            )
                        ),
                        "verified" => false,
                        "restricted" => true,
                        "stats" => array(
                            "checkinsCount" => 262,
                            "usersCount" => 27,
                            "tipCount" => 1
                        ),
                        "specials" => array(
                            "count" => 0,
                            "items" => array()
                        ),
                        "hereNow" => array(
                            "count" => 1,
                            "groups" => array(
                                array(
                                    "type" => "others",
                                    "name" => "Other people here",
                                    "count" => 1,
                                    "items" => array()
                                )
                            )
                        ),
                        "referralId" => "v-1384168938",
                        "loc" => array(
                            "type" => "Point",
                            "coordinates" => array(
                                -4.292427,
                                55.874239
                            )
                        )
                    )
                )
            ),
            "status" => "OK"
        )
    );

    /**
     * @var \Urban\Models\BusyVenues mock
     */
    private $_mockedService = null;

    /**
     *
     */
    public function setUp()
    {
        $this->_mockedService = $this->getMockBuilder('Urban\Models\BusyVenues')
            ->setMethods(array('__construct'))
            ->setConstructorArgs(array('testQuery', 'testDate'))
            ->disableOriginalConstructor()
            ->getMock();

        $this->_mockedService->response = self::RESPONSE_VALID;
        $this->_mockedService->queryDate = strtotime('2015-07-01');
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
    public function testGetCount()
    {
        $twitterCount = $this->_mockedService->getCount();

        $this->assertTrue(array_key_exists('date', $twitterCount));
        $this->assertTrue(array_key_exists('count', $twitterCount));
        $this->assertEquals(0, $twitterCount['count']);
    }

    /**
     *
     */
    public function testGetData()
    {
        $twitterData = $this->_mockedService->getData();

        $this->assertEquals(1, count($twitterData));

        $dataEntry = array_values($twitterData)[0];

        $this->assertTrue(array_key_exists('class', $dataEntry));
        $this->assertTrue(array_key_exists('venue', $dataEntry));
        $this->assertTrue(array_key_exists('dateString', $dataEntry));
        $this->assertTrue(array_key_exists('users', $dataEntry));
        $this->assertTrue(array_key_exists('checkins', $dataEntry));
        $this->assertTrue(array_key_exists('location', $dataEntry));

        $this->assertEquals('venue', $dataEntry['class']);
        $this->assertEquals('Gregory Building - College Academic Building', $dataEntry['venue']);
    }
}