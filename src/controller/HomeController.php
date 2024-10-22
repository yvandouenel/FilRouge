<?php

namespace Sthom\FilRouge\controller;

use Sthom\FilRouge\_utils\JwtManager;
use Sthom\FilRouge\AbstractController;

class HomeController extends AbstractController
{
    public final function getHome(): string
    {
        return $this->sendHtml('home', [
            'name' => 'John Doe',
            'age' => 30,
            'job' => 'Développeur'
        ]);
    }

    public final function getDatas(): string
    {

        $token =  JwtManager::generate('secret', [
            'name' => 'John Doe',
            'age' => 30,
            'job' => 'Développeur'
        ]);
        return $this->sendJson([
            'token' => $token
        ]);
    }
}