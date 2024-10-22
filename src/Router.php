<?php
namespace Sthom\FilRouge;
class Router {



    public function __construct(private readonly array $routes) {}



    /**
     * @method dispatch
     * Cette méthode permet de dispatcher une requête HTTP
     *
     * @param string $method
     * @param string $uri
     * @return string
     */
    public final function dispatch(string $method, string $uri, array $queryParameters) : string {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $params = $this->matchPath($route['path'], $uri);
                if ($params !== false) {
                    $class = explode('@', $route['handler'])[0];
                    $namespace = 'Sthom\\FilRouge\\controller\\';
                    $controller = $namespace . $class;
                    $method = explode('@', $route['handler'])[1];
                    $controllerInstance = new $controller();
                    return $controllerInstance->$method(...array_values($params));
                }
            }
        }

        // Route non trouvée
        header("HTTP/1.0 404 Not Found");
        return "404 Not Found";
    }



    /**
     * @method matchPath
     * Cette méthode permet de comparer un chemin de route avec une URI
     *
     * @param string $routePath
     * @param string $uri
     * @return array|bool
     */
    private function matchPath(string $routePath, string $uri) : array|bool {
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        $params = [];
        foreach ($routeParts as $index => $routePart) {
            if ($routePart[0] === ':') {
                $params[substr($routePart, 1)] = $uriParts[$index];
            } elseif ($routePart !== $uriParts[$index]) {
                return false;
            }
        }

        return $params;
    }
}

