<?php

namespace App\Controller\User;

use Framework\Controller\AbstractController;

class Login extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('user/login.html.twig',[
            'firstName' => 'Boris',
            'loopUntil' => 10,
            'users' => ['Jean', 'Paul'],
        ]);
    }
}
