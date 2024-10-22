<?php

namespace Sthom\FilRouge;

class Kernel
{

    private Router $router;
    private Model $model;


    private static ?Kernel $instance = null;
    private function __construct(private array $env) {}


    /**
     * @method build
     * Cette méthode permet de récupérer l'instance de l'application
     *
     * @param array $env
     * @return Kernel
     */
    public static final function setup(array $env, array $routes): self
    {
        if (self::$instance === null) {
            self::$instance = new self($env);
            self::$instance->router = new Router($routes);
            self::$instance->model = Model::getInstance($env);
        }
        return self::$instance;
    }

    /**
     * @method boot
     * Cette méthode permet de démarrer l'application
     *
     * @return void
     */
    public final function boot(string $path, array $queryParameters): void
    {
        echo $this->router->dispatch($_SERVER['REQUEST_METHOD'], $path, $queryParameters);
    }



}