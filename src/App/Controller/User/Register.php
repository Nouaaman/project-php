<?php

namespace App\Controller\User;

use App\Entity\User;
use Framework\Controller\AbstractController;

class Register extends AbstractController
{
  public function __invoke()
  {
    if ($this->isPost()) {
      // create the user inside the database
      //
      $this->redirect('/');
    }

    $boris = new User();

    return $this->render(
      'user/register.html.twig',
      [
        'value' => $boris
      ]);
  }
}

