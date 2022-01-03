<?php

namespace App\Controller\Game;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Searchplayer extends AbstractController
{

    public function __invoke()
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

        if ($this->isPost()) {

            if (isset($_POST['playerUsername']) && !empty($_POST['playerUsername'])) {
                $playerUsername = $this->formatInput($_POST['playerUsername']);
                $results = $this->searchPlayers($playerUsername);
                echo json_encode($results);
            }
        }
    }

    public function searchPlayers(string $match)
    {
        try {

            $sql = "SELECT `username` FROM `User` WHERE `username` LIKE '%{$match}%' LIMIT 5";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            exit($e->getMessage());
            return false;
        }
        return false;
    }

    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
