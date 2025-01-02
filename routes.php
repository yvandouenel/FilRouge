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
    "/roleuser" => [
        "CONTROLLER" => "RoleUserController",
        "METHOD" => "index",
        "HTTP_METHODS" => "GET",
        'AUTH' => ['ROLE_USER']
    ],
    "/roleadmin" => [
        "CONTROLLER" => "RoleAdminController",
        "METHOD" => "index",
        "HTTP_METHODS" => "GET",
        'AUTH' => ['ROLE_ADMIN']
    ],
    "/login" => [
        "CONTROLLER" => "AuthController",
        "METHOD" => "login",
        "HTTP_METHODS" => ["GET", "POST"],
    ],
    "/logout" => [
        "CONTROLLER" => "AuthController",
        "METHOD" => "logout",
        "HTTP_METHODS" => ["GET"],
    ],
    "/register" => [
        "CONTROLLER" => "AuthController",
        "METHOD" => "register",
        "HTTP_METHODS" => ["GET", "POST"],
    ],
];
