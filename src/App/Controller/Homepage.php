<?php

namespace App\Controller;

use Framework\Controller\AbstractController;

class Homepage extends AbstractController
{
    private $userIsConnected = false;
    private $username = '';

    public function __invoke(): string
    {
        session_start();

        if ($this->isPost() && isset($_POST['signOut'])) {
            session_destroy();
            $this->redirect('/');
        }
        //check if user is connected to show profile link and icons
        if (array_key_exists('username', $_SESSION) && !empty($_SESSION['username'])) {
            $this->userIsConnected = true;
            $this->username = $_SESSION['username'];
        }

        return $this->render('home.html.twig', [
            'userIsConnected' => $this->userIsConnected,
            'username' => $this->username
        ]);
    }
}
