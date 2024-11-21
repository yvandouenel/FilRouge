<?php

namespace Sthom\Kernel;

class Kernel
{
    public static function boot(): void
    {
        Configuration::loadConfiguration();
        Router::dispatch();
    }

}