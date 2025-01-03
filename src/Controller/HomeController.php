<?php

namespace Sthom\App\Controller;

use Sthom\App\Model\User;
use Sthom\Kernel\Utils\AbstractController;
use Sthom\Kernel\Utils\Repository;
use Sthom\Kernel\Utils\Security;

class HomeController extends AbstractController
{
    final public function index(): void
    {
        if (Security::isConnected()) {
            $user = $_SESSION['USER'];
            dd($user);

            return $this->render('home/index.php', [
                'title' => 'Page d\'accueil',
                'user' => $user,
            ]);
        } else {
            $this->redirect('/login');
        }
    }

    final public function create(): void
    {
        $this->json(['message' => 'create']);
    }


}

