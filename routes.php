<?php
const ROUTES = [
    "/" => [
        "CONTROLLER" => "HomeController",
        "METHOD" => "index",
        "HTTP_METHODS" => "GET",
        'AUTH' => ['ROLE_USER', 'ROLE_ADMIN']
    ],
    "/create" => [
        "CONTROLLER" => "HomeController",
        "METHOD" => "create",
        "HTTP_METHODS" => "POST",
        'AUTH' => ['ROLE_USER', 'ROLE_ADMIN']
    ],
];
