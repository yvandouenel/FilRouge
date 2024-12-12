<?php

namespace Sthom\App\Controller;

use Sthom\Kernel\Utils\AbstractController;

class TestController extends AbstractController
{
    public final function index(): void
    {
        $this->render('test.php');
    }
}
