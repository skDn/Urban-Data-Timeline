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
    'uses' => '\Urban\Http\Controllers\SearchController@event',
    'as' => 'event',
]);

Route::get('/comparison', [
    'uses' => '\Urban\Http\Controllers\ComparisonController@comparison',
    'as' => 'comparison',
]);

Route::get('/event/search', [
    'uses' => '\Urban\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
]);

Route::get('/event/search/count', [
    'uses' => '\Urban\Http\Controllers\CountController@getUserCount',
    'as' => 'search.count',
]);

Route::get('/event/compare', [
    'uses' => '\Urban\Http\Controllers\ComparisonController@compareTwoEvents',
    'as' => 'comparison.results',
]);
Route::get('/test/', [
    'uses' => '\Urban\Http\Controllers\TestController@test',
    'as' => 'test.results'
]);
