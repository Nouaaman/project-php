<?php

namespace App\Controller\Admin\Users;

use Framework\Controller\AbstractController;
use App\Models\DatabaseConnect;
use App\Entity\User;



class Adduser extends AbstractController
{
    public $addUserMessages = [];

    public function __invoke()
    {
        $this->addUserMessages;

        if ($this->isPost()) {

            if (isset($_POST['action']) && $_POST['action'] == 'addUser') {
                $username = $this->formatInput($_POST['username']);
                $exist = false;
                if ($this->checkExisting('username', $username)) {
                    $exist = true;
                    $this->addUserMessages['username'] = 'Username existe deja.';
                };

                $email = $this->formatInput($_POST['email']);
                if ($this->checkExisting('email', $email)) {
                    $exist = true;
                    $this->addUserMessages['email'] = 'Email existe deja.';
                };

                if (!$exist) {
                    $formData = $this->getSignUpData();
                    if ($formData != false) {
                        $user = new User();
                        $user->setFirstName($formData['firstName']);
                        $user->setLastName($formData['lastName']);
                        $user->setUsername($formData['username']);
                        $user->setEmail($formData['email']);
                        $user->setPassword($formData['password']);
                        $this->registerUser($user);

                        $_SESSION['username'] = $formData['username'];
                        $this->redirect('/admin/users');
                    }
                }
            }
        }

        return $this->render('admin/adduser.html.twig', [
            'addUserMessages' => $this->addUserMessages,
            'post' => $_POST
        ]);
    }
    public function checkExisting(string $searchBy, string $parameter): bool
    {
        try {

            $sql = "SELECT count(*) FROM `User` WHERE `{$searchBy}` = :parameter";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":parameter", $parameter);
            $stmt->execute();
            $results = $stmt->fetchColumn();
            return $results > 0;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return true;
        } catch (\Throwable $e) {
            exit($e->getMessage());
            return true;
        }
        return false;
    }
    public function registerUser(User $user)
    {

        try {

            $sql = "INSERT INTO `User` (`firstName`,`lastName`,`username`,`email`,`password`,`createdAt`) 
            VALUES(:firstName,:lastName,:username,:email,:userPassword,:createdAt)";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":firstName", $user->getFirstName(), \PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $user->getLastName(), \PDO::PARAM_STR);
            $stmt->bindParam(":username", $user->getUsername(), \PDO::PARAM_STR);
            $stmt->bindParam(":email", $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindParam(":userPassword", $user->getPassword(), \PDO::PARAM_STR);
            $currentDate = Date("Y-m-d");
            $stmt->bindParam(":createdAt", $currentDate, \PDO::PARAM_STR, 10);

            $stmt->execute();

            return true;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            exit($e->getMessage());
            return false;
        }
    }
    public function getSignUpData(): array|bool
    {
        $firstName = $lastName = $username = $email = $password = $passwordConfirmation = '';
        $isValid = true;
        //first name 
        if (empty($_POST["firstName"])) {
            $this->addUserMessages['firstName'] = 'Prenom obligatoire.';
            $isValid = false;
        } else {

            $firstName = $this->formatInput($_POST["firstName"]);
            // check if only contains letters and whitespace
            if (!preg_match("/^([a-zA-Z' ]+)$/", $firstName)) {
                $this->addUserMessages['firstName'] = 'Prenom invalide.';
                $isValid = false;
            }
        }

        //last name
        if (empty($_POST["lastName"])) {
            $this->addUserMessages['lastName'] = 'Nom obligatoire.';
            $isValid = false;
        } else {

            $lastName = $this->formatInput($_POST["lastName"]);
            // check if only contains letters and whitespace
            if (!preg_match("/^([a-zA-Z' ]+)$/", $lastName)) {
                $this->addUserMessages['lastName'] = 'Nom invalide.';
                $isValid = false;
            }
        }

        //username
        if (empty($_POST["username"])) {
            $this->addUserMessages['username'] = 'Username obligatoire.';
            $isValid = false;
        } else {

            $username = $this->formatInput($_POST["username"]);
            // check username for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $this->addUserMessages['username'] =  'Username invalide.';
                $isValid = false;
            }
        }

        //email
        if (empty($_POST["email"])) {
            $this->addUserMessages['email'] = 'Email obligatoire.';
            $isValid = false;
        } else {

            $email = $this->formatInput($_POST["email"]);
            // check username for no space or .. or ._.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addUserMessages['email'] = 'Email invalide.';
                $isValid = false;
            }
        }
        //password
        if (empty($_POST["password"]) || empty($_POST["passwordConfirmation"])) {
            $this->addUserMessages['password'] = 'Mot de passe obligatoire.';
            $isValid = false;
        } else {

            $password = stripslashes($_POST["password"]);
            $password = htmlspecialchars($password);
            $passwordConfirmation = stripslashes($_POST['passwordConfirmation']);
            $passwordConfirmation = htmlspecialchars($passwordConfirmation);
            // check username for no space or .. or ._.
            if ($password !== $passwordConfirmation) {
                $this->addUserMessages['password'] = 'Mot de passe non identiques.';
                $isValid = false;
            }
        }
        if (!$isValid) {
            return false;
        } else {
            return [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ];
        }
    }
    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
