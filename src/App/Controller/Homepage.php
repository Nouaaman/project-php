<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Homepage extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('home.html.twig', [
            'firstName' => 'Boris',
            'loopUntil' => 10,
            'users' => ['Jean', 'Paul'],
        ]);
    }
}
