<?php

namespace Sthom\Kernel;


use Dotenv\Dotenv;

class Kernel
{


    /**
     * Le constructeur de la classe Kernel
     * Il permet de charger la configuration de l'application
     * de démarrer la session et de charger les routes de l'application
     */
    public function __construct()
    {
        $this->loadConfiguration();
        $this->startSession();
        $this->loadRouting();
    }


    /**
     * Cette méthode permet de charger les routes de l'application
     * Elle inclut le fichier de configuration des routes
     * Elle instancie un routeur et lui demande de dispatcher la requête
     *
     * @return void
     *
     */
    private function loadRouting(): void
    {
        include './../config/routes.php';
        $router = new Router(ROUTES);
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $parameters);
        $router->dispatch($_SERVER['REQUEST_METHOD'], $currentPath, $parameters);
    }


    /**
     * Cette méthode permet de charger la configuration de l'application
     * Elle utilise la bibliothèque Dotenv pour charger les variables d'environnement
     *
     * @return void
     *
     */
    private function loadConfiguration(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }


    /**
     * Cette méthode permet de démarrer la session
     * Si la session n'est pas démarrée, elle la démarre
     * Sinon, elle régénère l'identifiant de session
     *
     * @return void
     *
     */
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } else {
            session_regenerate_id();
        }
    }
}