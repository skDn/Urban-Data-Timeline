<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => Urban\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    /* {"request":{"query":"yesscotland","date":"2014-08-25"}} */
    'twitter' => [
        'url' => 'http://localhost:8080/ubdc-web/getTweetStats.action',
    ],
    /* {request: {lat: 55.8748 , lon:-4.2929, radius:0.05, timestamp: "2015-07-01 14:00:00"}} */
    'busyVenues' => [
        'url' => 'http://localhost:8080/ubdc-web/getBusyVenues.action',
    ],
    /*  {"request":{"tiploc":"GLGQHL","shortDate":"2015-04-01","minimumDelay":"5"}}  */
    'delayedServices' => [
        'url' => 'http://localhost:8080/ubdc-web/getDelayedServices.action',
    ],
    /* {"request":{"tiploc":"GLGQHL","shortDate":"2015-04-01","minDelay":"5"}}  */
    'delaysTimeSeries' => [
        'url' => 'http://localhost:8080/ubdc-web/getDelaysTimeSeries.action',
    ],
    /*   {"request": {"lat": 55.8580 , "lon":-4.2590, "radius": 1.0}}   */
    'trainStations' => [
        'url' => 'http://localhost:8080/ubdc-web/getTrainStations.action',
    ],

    


];
