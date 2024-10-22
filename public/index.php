<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Sthom\FilRouge\Kernel;

$env = Dotenv::createImmutable(__DIR__ . '/..');
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $parameters);
$routes = [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => 'HomeController@getHome'
    ],
    [
        'method' => 'GET',
        'path' => '/datas',
        'handler' => 'HomeController@getDatas'
    ]
];

$kernel = Kernel::setup($env->load(), $routes);
$kernel->boot($path, $parameters);


