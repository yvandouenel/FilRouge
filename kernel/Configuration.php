<?php

namespace Sthom\Kernel;

class Configuration
{

    /**
     * Cette méthode permet de charger la configuration de l'application
     * Elle utilise la bibliothèque Dotenv pour charger les variables d'environnement
     *
     * @return void
     *
     */
    public static function loadConfiguration(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

}