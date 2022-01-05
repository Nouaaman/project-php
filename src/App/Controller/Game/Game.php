<?php

namespace App\Controller\Game;

use App\Entity\Question;
use App\Models\DatabaseConnect;
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

        return $this->render('game/game.html.twig', [
            'username' => $_SESSION['username'],
            'questions' =>  $this->displayQuestions(),
        ]);
    }
    public function displayQuestions()
    {
        try {
            $questions = "SELECT * FROM Question WHERE level= 1
            ORDER BY RAND()
            LIMIT 1;";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($questions);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
            echo ($results);
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return [];
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return [];
        }
        return [];
    }
}
