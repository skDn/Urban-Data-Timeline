<?php

// You can find the keys here : https://apps.twitter.com/

return [
	'debug'               => false,

	'API_URL'             => 'api.twitter.com',
	'UPLOAD_URL'          => 'upload.twitter.com',
	'API_VERSION'         => '1.1',
	'AUTHENTICATE_URL'    => 'https://api.twitter.com/oauth/authenticate',
	'AUTHORIZE_URL'       => 'https://api.twitter.com/oauth/authorize',
	'ACCESS_TOKEN_URL'    => 'https://api.twitter.com/oauth/access_token',
	'REQUEST_TOKEN_URL'   => 'https://api.twitter.com/oauth/request_token',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => function_exists('env') ? env('TWITTER_CONSUMER_KEY', '1zi1F3Df6gCihKTEtZoCQyUb6') : '',
	'CONSUMER_SECRET'     => function_exists('env') ? env('TWITTER_CONSUMER_SECRET', 'gnIyfkzM4YDP8DB3vA1EsgsjL1dzDpVBEZmQorAVNR60dv7y21') : '',
	'ACCESS_TOKEN'        => function_exists('env') ? env('TWITTER_ACCESS_TOKEN', '3762104783-yJxf20PBpOEdjVHOotJBwPuMOAUn0asenlCE3Wr') : '',
	'ACCESS_TOKEN_SECRET' => function_exists('env') ? env('TWITTER_ACCESS_TOKEN_SECRET', 'aEOV5XHhPZiltMasjkIiZeqb90rFskq8UgP5lWkYNpbIy') : '',
];
