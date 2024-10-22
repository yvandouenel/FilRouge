<?php

namespace Sthom\FilRouge;



/**
 * @class AbstractController
 * Cette classe permet de définir des méthodes communes à tous les contrôleurs
 * Ces méthodes permettent d'envoyer des réponses JSON ou HTML aux clients
 */
class AbstractController
{

    protected $request;

    public function __construct()
    {
        $this->request = [
            'body' => json_decode(file_get_contents('php://input'), true) ?? [],
            'query' => $_GET,
            'params' => $_POST,
            'auth' => $_SERVER['HTTP_AUTHORIZATION'] ?? null,
            'files' => $_FILES,
            'method' => $_SERVER['REQUEST_METHOD']
        ];

    }

    /**
     * @method sendJson
     * Cette méthode permet d'envoyer une réponse JSON
     *
     * @param array $data
     * @param int $status
     * @return string
     */
    public final function sendJson(array $data, int $status = 200) : string
    {
        http_response_code($status); // Définit le code de statut HTTP
        header('Content-Type: application/json'); // Définit le type de réponse à JSON
        return json_encode($data); // Retourne les données encodées en JSON
    }


    /**
     * @method sendHtml
     * Cette méthode permet d'envoyer une réponse HTML
     *
     * @param string $path
     * @param array $data
     * @param int $status
     * @return string
     */
    public final function sendHtml(string $path, array $data = [], int $status = 200) : string
    {
        try {
            http_response_code($status); // Définit le code de statut HTTP
            header('Content-Type: text/html'); // Définit le type de réponse à HTML
            extract($data); // Extrait les données du tableau associatif, et rend chaque clé disponible en tant que variable dans le fichier PHP
            include "./../src/views/$path.php"; // Inclut le fichier PHP
            return '';
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }


}