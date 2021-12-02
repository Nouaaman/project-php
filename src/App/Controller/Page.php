<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Page extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('questions/question.html.twig', [
            'id' => 10
        ]);
    }
}
