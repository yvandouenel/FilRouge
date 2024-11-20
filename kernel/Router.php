<?php

namespace Sthom\Kernel;
class Router
{


    public function __construct(private readonly array $routes){}


    /**
     * @method dispatch
     * Cette méthode permet de dispatcher une requête HTTP
     *
     * @param string $method
     * @param string $uri
     * @return string
     * @throws \Exception
     */
    public final function dispatch(string $method, string $uri, array $queryParameters): void
    {
        $isRouteFound = false;
        foreach ($this->routes as $route) {
            if ($route['method'] !== $_SERVER['REQUEST_METHOD']) {
                throw new \Exception('Method not allowed');
            }
            if ($route['path'] === $uri) {
                $class = explode('@', $route['handler'])[0];
                $namespace = $_ENV['CONTROLLER_NAMESPACE'];
                $controller = $namespace . $class;
                $method = explode('@', $route['handler'])[1];
                $controllerInstance = new $controller();
                $controllerInstance->$method(...array_values($queryParameters));
                $isRouteFound = true;
            }
        }
        if (!$isRouteFound) {
            throw new \Exception('Route not found');
        }
    }
}

