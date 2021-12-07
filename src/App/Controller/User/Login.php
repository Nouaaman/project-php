<?php

namespace App\Controller\User;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;


class Login extends AbstractController
{

    public $registerMessages;
    public function __invoke()
    {
        $this->registerMessages = [];
        if ($this->isPost()) {
            if (isset($_POST['action']) && $_POST['action'] == 'signUp') {
                // $this->insertUser();
                $username = $this->formatInput($_POST['username']);

                $res = $this->userExits($username);
                array_push($this->registerMessages, $res);
            }
            // // $this->redirect('/');
        }

        return $this->render('user/login.html.twig', ['registerMessages' => $this->registerMessages]);
    }

    /* check if user exists in db by column of choice*/
    public function userExits(string $param): bool
    {
        try {

            $sql = "SELECT count(*) FROM `User` WHERE `username` = :parameter";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":parameter", $param);
            $stmt->execute();
            $results = $stmt->fetchColumn();
            return $results > 0;
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return true;
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return true;
        }
        return false;
    }

    public function insertUser()
    {

        // $username = $this->formatInput($_POST['username']);
        // if ($this->userExits($username)) {
        //     array_push($this->registerMessages, 'user Exists');
        // } else {
        //     array_push($this->registerMessages, 'user not Exists');
        // }
        // // $sqlQuery = "INSERT INTO ";
        // // $stmt = $connection->;
    }



    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
