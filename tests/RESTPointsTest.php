<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RESTPointsTest extends TestCase
{
    const lat = 'lat=55.8748';
    const lng = 'lng=-4.2930';
    const url = '/rest/nearbyVenues';
    const question = '?';
    const andsign = '&';


    public function testBusyVenuesStatus()
    {
        $this->get(self::url.self::question.self::lat.self::andsign.self::lng)
            ->seeJson([
                'status' => 'OK'
            ]);
    }
    public function testBusyVenuesErrorLng()
    {
        $this->get(self::url.self::question.self::lat)
            ->seeJson([
                'status' => 'failed'
            ]);
    }
    public function testBusyVenuesErrorLat()
    {
        $this->get(self::url.self::question.self::lng)
            ->seeJson([
                'status' => 'failed'
            ]);
    }

    public function testBusyVenuesErrorLat1()
    {
        $this->get(self::url.self::question.'lat=this is wrong lat'.self::andsign.self::lng)
            ->seeJson([
                'status' => 'failed'
            ]);
    }


    public function testBusyVenuesErrorLng1()
    {
        $this->get(self::url.self::question.'lng=this is wrong lng'.self::andsign.self::lat)
            ->seeJson([
                'status' => 'failed'
            ]);
    }

    public function testCount()
    {
        $this->get('http://localhost:8001/rest/count?query=yesscotland&date=2014-08-25&lat=55.8748')
            ->see('yesscotland');
    }

}
