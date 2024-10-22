<?php

namespace Sthom\FilRouge;

class Model
{

    private static ?Model $instance = null;
    private function __construct(private array $env) {}

    /**
     * @return Model|null
     */
    public static function getInstance(array $env = []): ?Model
    {
        if (self::$instance === null) {
            self::$instance = new self($env);
        }
        return self::$instance;
    }



}