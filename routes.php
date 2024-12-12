<?php
const ROUTES = [
    "/" => [
        "CONTROLLER" => "HomeController",
        "METHOD" => "index",
        "HTTP_METHODS" => "GET",
    ],
    "/create" => [
        "CONTROLLER" => "HomeController",
        "METHOD" => "create",
        "HTTP_METHODS" => "POST",
        'AUTH' => ['ROLE_USER', 'ROLE_ADMIN']
    ],
    "/test" => [
        "CONTROLLER" => "TestController",
        "METHOD" => "index",
        "HTTP_METHODS" => "GET",
        'AUTH' => ['ROLE_USER', 'ROLE_ADMIN']
    ],
    "/login" => [
        "CONTROLLER" => "AuthController",
        "METHOD" => "login",
        "HTTP_METHODS" => ["GET", "POST"],
    ],
    "/register" => [
        "CONTROLLER" => "AuthController",
        "METHOD" => "register",
        "HTTP_METHODS" => ["GET", "POST"],
    ],
];
