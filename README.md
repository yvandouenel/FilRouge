# FilRouge

## Description

Ce projet est un micro-framework PHP qui permet de créer des applications web simple en suivant le modèle MVC.

## Installation

Pour installer le projet, il suffit de cloner le dépôt git et d'installer les dépendances avec composer.

```bash
git clone {url_du_depot_git}
composer install
```

## Configuration

Pour configurer l'application, il faut précisier des variables d'environnement dans un fichier `.env` à la racine du
projet.

```env
DSN=mysql:host=localhost;dbname={nom_de_la_base_de_donnees}
USERNAME={utilisateur_de_la_base_de_donnees}
PASSWORD={mot_de_passe_de_la_base_de_donnees}
CONTROLLER_NAMESPACE={namespace_des_controleurs}\Controller\
MODEL_NAMESPACE={namespace_des_models}\Model\
DEBUG=true
```

## Utilisation

Pour lancer l'application, il suffit de lancer un serveur web local avec la commande suivante.
Cette commande doit être exécutée à la racine du projet.

```bash
php -S localhost:8000 -t public
```

Pour accéder à l'application, il suffit d'ouvrir un navigateur et de se rendre à l'adresse `http://localhost:8000`.

### Exemple de création d'une page d'accueil

#### Création d'un contrôleur

Pour créer un contrôleur, il suffit de créer une classe dans le dossier `src/Controller` qui hérite de la
classe `AbstractController`.

```php
<?php

namespace Sthom\App\Controller;

use Sthom\Kernel\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home/index', ["title" => "Page d'accueil"]);
    }
}
```

#### Création d'une vue

Ensuite, la première chose à faire est de créer une vue pour la page d'accueil, il faut créer un fichier de vue dans le
dossier 'views' qui correspond au lien retourné par la méthode `render` du contrôleur.'
Vous pouvez utiliser les variables passées en paramètre de la méthode `render` dans votre vue.

```html

<h1><?php echo $title ?></h1>

<p>Bienvenue sur la page d'accueil de notre site.</p>
```

#### Création d'une route

Enfin, il faut créer une route dans le fichier `routes.php` qui associe une URL à un contrôleur et une méthode.

```php
<?php
$routes = [
    ['method' => 'GET', 'path' => '/', 'handler' => 'HomeController@index'],
];
define('ROUTES', $routes);
```

Dans cet exemple, la route `/` est associée à la méthode `index` du contrôleur `HomeController`. 
La clé 'handler' de la route doit être sous cette forme `NomDuControleur@NomDeLaMethode` pour que le framework puisse reconnaître le contrôleur et la méthode à appeler.
La clé `method` permet de préciser le verbe HTTP pour bloquer l'accès à certaines routes en fonction de la méthode HTTP.

```php
<?php
$routes = [
    ['method' => 'GET', 'path' => '/', 'handler' => 'HomeController@index'],
    ['method' => 'POST', 'path' => '/login', 'handler' => 'AuthController@login']
];
define('ROUTES', $routes);
```

### Exemple d'utilisation d'un modèle dans un contrôleur grâce au Repository

Ce framework permet d'utiliser des modèles pour interagir avec la base de données.
Pour créer un modèle, il suffit de créer une classe dans le dossier `src/Model`. Cette classe sera une représentation
d'une table de la base de données.

```php

<?php

namespace Sthom\App\Model;

class User
{
    private int ?$id;
    private string $username;
    private string $password;
    
    // Getters et setters à implémenter
    // /!\ Attention, on ne doit pas implémenter le setter pour l'id car il est généré automatiquement par la base de données
    public function getId(): ?int
    {
        return $this->id;
    }
    
```

Attention, il est important de respecter les conventions de nommage pour que le modèle fonctionne correctement.
Les propriétés de la classe doivent correspondre aux colonnes de la table en base de données.

Pour intéragir avec la base de données, il faudra créer un Repository qui permettra de faire des requêtes SQL sur la table associée au modèle.
On lui passera en paramètre le nom complet de la classe du modèle.

```php

<?php

namespace Sthom\App\Controller;

use Sthom\Kernel\AbstractController;
use Sthom\App\Model\User;

class HomeController extends AbstractController
{
    public function index()
    {
        $userRepo = new Repository(User::class);
        $user = $userRepo->getById(1); // dans cet exemple, on récupère l'utilisateur avec l'id 1
        return $this->render('home/index', ["title" => "Page d'accueil", "user" => $user]);
    }
}
```

Cette classe Repository nous met à disposition des méthodes pour effectuer le CRUD sur la table associée au modèle.
Retrouvez la liste des méthodes disponibles dans la classe `Repository`.


Pour plus d'informations, vous pouvez consulter les classes dans le dossier `kernel` qui contiennent la logique du framework.














