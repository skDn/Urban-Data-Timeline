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

	'CONSUMER_KEY'        => function_exists('env') ? env('TWITTER_CONSUMER_KEY', 'awpkgjnYx7f69Ye8LRW7LPg0K') : '',
	'CONSUMER_SECRET'     => function_exists('env') ? env('TWITTER_CONSUMER_SECRET', 'iwYtjbMuFVOOWpfdnHYq8OpLBQMvElXSlsUGgUrSduNcE3MdvI') : '',
	'ACCESS_TOKEN'        => function_exists('env') ? env('TWITTER_ACCESS_TOKEN', '3762104783-CmyoLwNXlnH9hGruJVx43aP7035I9YuKU7mofED') : '',
	'ACCESS_TOKEN_SECRET' => function_exists('env') ? env('TWITTER_ACCESS_TOKEN_SECRET', 'jnxHvvtSSYE2ECi9mg3AaaSZ1d8MKZbrWZWg6HTG3LCL1') : '',
];
