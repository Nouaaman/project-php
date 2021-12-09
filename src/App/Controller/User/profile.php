<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;


class Profile extends AbstractController
{

    public function __invoke(): string
    {
        return $this->render('user/profile.html.twig', []);
    }
}
