<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Urban\Models\BusyVenues;
class IntegrationTest extends TestCase
{
    /**
     * Integration Test with Busy Venues Service
     *
     * @return void
     */
    public function testIntegrationWithBusyVenuesService()
    {
        $twitterData = new BusyVenues(55.874863914508, -4.293143904860926, '2014-08-28', 0);
        $twitterData = $twitterData->getData();

        $this->assertEquals(1, count($twitterData));

        $dataEntry = array_values($twitterData)[0];

        $this->assertTrue(array_key_exists('class', $dataEntry));
        $this->assertTrue(array_key_exists('venue', $dataEntry));
        $this->assertTrue(array_key_exists('dateString', $dataEntry));
        $this->assertTrue(array_key_exists('users', $dataEntry));
        $this->assertTrue(array_key_exists('checkins', $dataEntry));
        $this->assertTrue(array_key_exists('location', $dataEntry));

        $this->assertEquals('venue', $dataEntry['class']);

    }
}
