<?php

namespace App\Controller\User;

// use App\Controller\Database\DatabaseConnect;
use Framework\Controller\AbstractController;


class Login extends AbstractController
{

    public $errors;
    public function __invoke()
    {
        $this->errors = [];
        if ($this->isPost()) {
            if (isset($_POST['action']) && $_POST['action'] == 'signUp') {
                // $this->insertUser();
                $username = $this->formatInput($_POST['username']);
                $res = $this->userExits($username);
                array_push($this->errors, $res);
            }
            // // $this->redirect('/');
        }

        return $this->render('user/login.html.twig', ['errors' => $this->errors]);
    }

    /* check if user exists in db*/
    public function userExits(): bool
    {
        try {

            // $sql = "SELECT count(*) FROM User WHERE username = :username";
            $sql = "SELECT COUNT(*) FROM User";
            // $db = new App\Controller\Database\DatabaseConnect();
            $connection = $db->db_connect();
            $stmt = $connection->prepare($sql);
            // $stmt->bindParam(':username', $username);
            $stmt->execute();
            $results = $stmt->fetchColumn();
            return $results > 0;
        } catch (\Exception $ex) {
            array_push($this->errors, $ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            array_push($this->errors, $e->getMessage());
            return false;
        }
        // return false;
        return true;
    }

    public function insertUser()
    {

        $username = $this->formatInput($_POST['username']);
        if ($this->userExits($username)) {
            array_push($this->errors, 'user Exists');
        } else {
            array_push($this->errors, 'user not Exists');
        }
        // $sqlQuery = "INSERT INTO ";
        // $stmt = $connection->;
    }



    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
