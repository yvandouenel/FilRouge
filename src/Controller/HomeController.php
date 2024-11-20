<?php

namespace Sthom\App\Controller;

use Sthom\App\Model\User;
use Sthom\Kernel\AbstractController;
use Sthom\Kernel\Repository;

class HomeController extends AbstractController
{
    public function index(): void
    {
        $repoUser = new Repository(User::class);
        $repoUser->delete(1);

        $this->render('home/index', ['title' => 'Home']);
    }

    public function home(string $name, int $id): void
    {
        $this->render('home/index', ['title' => 'Page d\'accueil']);
    }
}