<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class SignIn extends AbstractController
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
