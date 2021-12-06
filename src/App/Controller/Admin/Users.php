<?php

namespace App\Controller\Admin;

use Framework\Controller\AbstractController;

class Users extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('admin/users.html.twig', []);
    }
}
