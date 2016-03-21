<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewsTest extends TestCase
{
    /**
     * Test Home page
     *
     * @return void
     */
    public function testHomePage()
    {
        $this->call('GET', '/');

        $this->assertResponseOk();
    }

    /**
     * Test Home Page Content
     */
    public function testHomePageContent()
    {
        $this->visit('/')
            ->see('Urban Data Timeline');
    }

    /**
     * Test Event page
     *
     * @return void
     */
    public function testEventPage()
    {
        $this->call('GET', '/event');

        $this->assertResponseOk();
    }

    /**
     * Test Home page
     *
     * @return void
     */
    public function testComparePage()
    {
        $this->call('GET', '/comparison');

        $this->assertResponseOk();
    }

    /**
     * Test navigation
     */
    public function testNavigateCompare()
    {
        $this->visit('/')
            ->click('Compare')
            ->seePageIs('/comparison');
    }

    /**
     * Test navigation
     */
    public function testNavigateEvent()
    {
        $this->visit('/')
            ->click('Search')
            ->seePageIs('/event');
    }

    public function testSearchDateErrorUI()
    {
        $this->visit('/event')
            ->type('noscotland', 'queryFirst')
            ->press('Search')
            ->seePageIs('/event')
            ->see('The date field is required.');
    }

    public function testCompareDateErrorUI()
    {
        $this->visit('/comparison')
            ->type('noscotland', 'queryFirst')
            ->press('Search')
            ->seePageIs('/comparison')
            ->see('The date field is required.');
    }

    public function testCompareQueryErrorUI1()
    {
        $this->visit('/comparison')
            ->type('noscotland', 'queryFirst')
            ->press('Search')
            ->seePageIs('/comparison')
            ->see('The query second field is required.')
            ->dontSee('The query first field is required.');
    }

    public function testCompareQueryErrorUI2()
    {
        $this->visit('/comparison')
            ->type('noscotland', 'querySecond')
            ->press('Search')
            ->seePageIs('/comparison')
            ->see('The query first field is required.')
            ->dontSee('The query second field is required.');
    }
}
