<?php

namespace App\Controller\Game;

use Framework\Controller\AbstractController;

class Game extends AbstractController
{
    private $username = '';
    public function __invoke(): string
    {
        session_start();

        if (
            array_key_exists('username', $_SESSION)
            && !empty($_SESSION['username'])
        ) {
            $this->username = $_SESSION['username'];
        } else {
            $this->redirect('/login');
        }


        return $this->render('game/game.html.twig', []);
    }
}
