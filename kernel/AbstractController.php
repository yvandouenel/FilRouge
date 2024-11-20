<?php

namespace Sthom\Kernel;


/**
 * @class AbstractController
 * Cette classe permet de définir des méthodes communes à tous les contrôleurs
 * Ces méthodes permettent d'envoyer des réponses JSON ou HTML aux clients
 */
class AbstractController
{

    /**
     * @method sendJson
     * Cette méthode permet d'envoyer une réponse JSON
     *
     * @param array $data
     * @param int $status
     * @return string
     */
    public final function sendJson(array $data, int $status = 200): void
    {
        try {
            http_response_code($status); // Définit le code de statut HTTP
            header('Content-Type: application/json'); // Définit le type de réponse à JSON
            echo json_encode($data); // Retourne les données encodées en JSON
            die(); // Arrête l'exécution du script
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }


    /**
     * @method render
     * Cette méthode permet d'envoyer un document HTML en y intégrant des variables utilisables dans le fichier
     * Elle charge une base HTML, et y inclut le fichier PHP correspondant à la vue
     * @param string $path
     * @param array $data
     * @param int $status
     * @return string
     */
    public final function render(string $path, array $data = [], int $status = 200): void
    {
        try {
            http_response_code($status); // Définit le code de statut HTTP
            header('Content-Type: text/html'); // Définit le type de réponse à HTML
            $data['view'] = './../views/' . $path . '.php'; // Définit le chemin du fichier PHP
            extract($data); // Extrait les données du tableau associatif, et rend chaque clé disponible en tant que variable dans le fichier PHP
            include "./../views/base.php"; // Inclut le fichier PHP
            die(); // Arrête l'exécution du script
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }


    /**
     * @method redirect
     * Cette méthode permet de rediriger l'utilisateur vers une autre page en utilisant une redirection HTTP
     * Elle prend en paramètre une url
     *
     * @param string $route
     * @return void
     */
    public final function redirect(string $route): void {
        header('location: '.$route);
    }


}