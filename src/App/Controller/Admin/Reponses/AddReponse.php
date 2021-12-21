<?php

namespace App\Controller\Admin\Reponses;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class AddReponse extends AbstractController
{

    public function __invoke()
    {

        return $this->render(
            'admin/reponse/addreponse.html.twig',
            []
        );
    }
}
