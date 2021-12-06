<?php

namespace App\Controller\Admin;

use Framework\Controller\AbstractController;

class Questions extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('admin/questions.html.twig', []);
    }
}
