<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Login extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('login.html.twig',[
            'firstName' => 'Boris',
            'loopUntil' => 10,
            'users' => ['Jean', 'Paul'],
        ]);
    }
}
