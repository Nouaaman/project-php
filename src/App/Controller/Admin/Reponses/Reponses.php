<?php

namespace App\Controller\Admin\Reponses;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Reponses extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('admin/reponse/reponses.html.twig', []);
    }
}
