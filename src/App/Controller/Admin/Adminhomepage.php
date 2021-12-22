<?php

namespace App\Controller\Admin;

use App\Models\DatabaseConnect;

use Framework\Controller\AbstractController;

class Adminhomepage extends AbstractController
{

    private $userIsConnected = false;
    private $username = '';

    public function __invoke(): string
    {
        session_start();
        //check if user is connected to show profile link and icons
        if (
            array_key_exists('username', $_SESSION)
            && !empty($_SESSION['username'])
            && !empty($_SESSION['role'])
            && $_SESSION['role'] == 'admin'
        ) {
            $this->userIsConnected = true;
            $this->username = $_SESSION['username'];
        }else {
            $this->redirect('/');
        }

        return $this->render('admin/adminhomepage.html.twig', [
            'nbrOfQuestions' => $this->nbrOfQuestions(),
            'nbrOfUsers' => $this->nbrOfUsers()
        ]);
    }
    public function nbrOfUsers(): int
    {
        try {

            $sql = "SELECT count(*) FROM `User`";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return true;
        } catch (\Throwable $e) {
            exit($e->getMessage());
        }
    }
    public function nbrOfQuestions(): int
    {
        try {

            $sql = "SELECT count(*) FROM `Question`";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return true;
        } catch (\Throwable $e) {
            exit($e->getMessage());
        }
    }
}
