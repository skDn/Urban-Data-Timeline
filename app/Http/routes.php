<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/event', [
    'uses' => '\Urban\Http\Controllers\SearchController@index',
    'as' => 'event',
]);

Route::get('/event/search', [
    'uses' => '\Urban\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
]);

Route::get('/event/search/count', [
    'uses' => '\Urban\Http\Controllers\SearchController@getUserCount',
    'as' => 'search.count',
]);
