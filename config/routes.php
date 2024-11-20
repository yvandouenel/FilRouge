<?php
$routes = [
    ['method' => 'GET', 'path' => '/', 'handler' => 'HomeController@index'],
    ['method' => 'GET', 'path' => '/home/test', 'handler' => 'HomeController@home'],
];
define('ROUTES', $routes);
