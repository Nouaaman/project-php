<?php

namespace App\Controller\Admin\Users;

use Framework\Controller\AbstractController;

class Adduser extends AbstractController
{
    public function __invoke(): string
    {
        return $this->render('admin/adduser.html.twig');
    }
}
