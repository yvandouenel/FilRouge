<?php

namespace Sthom\Kernel;
class Router
{


    public function __construct(){}


    /**
     * @method dispatch
     * Cette méthode permet de dispatcher une requête HTTP
     *
     * @param string $method
     * @param string $uri
     * @return string
     * @throws \Exception
     */
    public final static function dispatch(): void
    {
        include './../config/routes.php';
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $parameters);
        $isRouteFound = false;
        foreach (ROUTES as $route) {
            if ($route['method'] !== $_SERVER['REQUEST_METHOD']) {
                throw new \Exception('Method not allowed');
            }
            if ($route['path'] === $currentPath) {
                $class = explode('@', $route['handler'])[0];
                $namespace = $_ENV['CONTROLLER_NAMESPACE'];
                $controller = $namespace . $class;
                $method = explode('@', $route['handler'])[1];
                $controllerInstance = new $controller();
                $controllerInstance->$method(...array_values($parameters));
                $isRouteFound = true;
            }
        }
        if (!$isRouteFound) {
            throw new \Exception('No route found');
        }
    }
}

