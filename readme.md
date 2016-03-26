##Setup

### Starting the server
Typically, a web server such as Apache or Nginx can be used to serve this application. If there is PHP 5.4+ installed that comes with PHP's built-in development server, the serve Artisan command can be used to start the application but only if it is executed into the main directory of the project:
$ php artisan serve
By default the HTTP-server will listen to port 8000. However if that port is already in use, the port can be specified. Just add the --port argument:
$ php artisan serve --port=8080

### Services configuration

Furthermore, the “Urban-Data-Timeline\config\services.php” file has to be modified with the urls to each of the services. This change is not required if a ssh tunnel to the services is opened, using the following command:
$ ssh -L 8080:localhost:9057 -L 8081:localhost:9058 GUID@sibu.dcs.gla.ac.uk "ssh -L 9057:130.209.67.145:8080 -L 9058:130.209.67.145:80 roma"

### Twitter API

Finally, if the communication with the genuine Twitter API is required in order to get tweets from any venue twitter account, the “Urban-Data-Timeline\config\ttwitter.php” file has to be modified with the corresponding CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN and ACCESS_TOKEN_SECRET. 

## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
