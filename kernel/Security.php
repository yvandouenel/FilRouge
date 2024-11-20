<?php

namespace Sthom\Kernel;

class Security
{

    /**
     * Cette méthode permet de savoir si l'utilisateur est connecté
     * ELle retourne true si une clé 'connected' est présente dans la session et qu'elle est à true
     * Sinon, elle retourne false
     */
    public final function isConnected():bool
    {
        if (isset($_SESSION['connected']) && $_SESSION['connected']===true) {
            return true;
        }
        return false;
    }


    /**
     * Cette méthode permet de déconnecter l'utilisateur
     * Elle met à false la clé 'connected' de la session
     */
    public final function disconnect():void
    {
        $_SESSION['connected'] = false;
    }


    /**
     * Cette méthode permet de connecter un utilisateur
     * Elle prend en paramètre un nom d'utilisateur et un mot de passe
     * Elle vérifie si l'utilisateur existe en base de données
     * Si c'est le cas, elle vérifie si le mot de passe est correct
     * Si c'est le cas, elle met à true la clé 'connected' de la session
     * Sinon, elle retourne un message d'erreur
     * @param string $username
     * @param string $password
     * @return mixed
     * @throws \Exception
     */
    public final function connect(string $username, string $password):mixed
    {
        $repository = new Repository('user');
        $result = $repository->getByAttributes(['username' => $username], false);
        if (!$result) {
            throw new \Exception('Identifiant ou mot de passe invalide');
        }
        if (password_verify($password, $result->getPassword())) {
            $_SESSION['connected'] = true;
            return true;
        } else {
            throw new \Exception('Identifiant ou mot de passe invalide');
        }
    }
}