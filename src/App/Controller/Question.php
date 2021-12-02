<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Question extends AbstractController
{
    public function __invoke(int $id): string
    {
        return $this->render('questions/question.html.twig', [
            'id' => $id
        ]);
    }
}
