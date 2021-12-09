<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;


class Login extends AbstractController
{

    private $registerMessages = [];
    private $loginMessages = [];
    private $classCss;

    public function __invoke()
    {
        session_start();

        //redirect to homepage in case session exists
        if (array_key_exists('username', $_SESSION) && !empty($_SESSION['username'])) {
            $this->redirect('/');
        }

        $this->classCss = '';
        $this->registerMessages;

        if ($this->isPost()) {

            /* ****************sign up  button***************/
            if (isset($_POST['action']) && $_POST['action'] == 'signUp') {
                $this->classCss = 'signing-up';
                $username = $this->formatInput($_POST['username']);
                $exist = false;
                if ($this->checkExisting('username', $username)) {
                    $exist = true;
                    $this->registerMessages['username'] = 'Username existe deja.';
                };

                $email = $this->formatInput($_POST['email']);
                if ($this->checkExisting('email', $email)) {
                    $exist = true;
                    $this->registerMessages['email'] = 'Email existe deja.';
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
                        $this->redirect('/login');
                    }
                }
            }


            /************Login button***************/
            if (isset($_POST['action']) && $_POST['action'] == 'login') {
                $username = $this->formatInput($_POST['username']);
                $password = $this->formatInput($_POST['password']);
                $exist = false;

                if ($this->checkExisting('username', $username)) {
                    $exist = true;
                };

                if (!$exist) {
                    $this->loginMessages['username'] = "Username n'existe pas.";
                } else {

                    if ($this->checkUserCredentials($username, $password)) {
                        //redirect to home page if connected
                        $_SESSION['username'] = $username;
                        $this->redirect('/');

                    } else {
                        $this->loginMessages['username'] = "Username ou mot de passe incorrect.";
                    }
                }
            }
        }

        return $this->render('user/login.html.twig', [
            'registerMessages' => $this->registerMessages,
            'loginMessages' => $this->loginMessages,
            'classCss' => $this->classCss,
            'post' => $_POST
        ]);
    }

    /* Login */
    function checkUserCredentials(string $username, string $password): bool
    {
        $databaseconnect = new DatabaseConnect();
        $connection = $databaseconnect->GetConnection();
        $stmt = $connection->prepare('SELECT `password` from `User` WHERE `username`=:username');
        $stmt->bindParam('username', $username, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (isset($result['password']) && ($password == $result['password'])) {
                return true;
            }
            return false;
        }

        return false;
    }

    /* check if user exists in db by column of choice*/
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

    //get data from post , return array of data or false if data invalid
    public function getSignUpData(): array|bool
    {
        $firstName = $lastName = $username = $email = $password = $passwordConfirmation = '';
        $isValid = true;
        //first name 
        if (empty($_POST["firstName"])) {
            $this->registerMessages['firstName'] = 'Prenom obligatoire.';
            $isValid = false;
        } else {

            $firstName = $this->formatInput($_POST["firstName"]);
            // check if only contains letters and whitespace
            if (!preg_match("/^([a-zA-Z' ]+)$/", $firstName)) {
                $this->registerMessages['firstName'] = 'Prenom invalide.';
                $isValid = false;
            }
        }

        //last name
        if (empty($_POST["lastName"])) {
            $this->registerMessages['lastName'] = 'Nom obligatoire.';
            $isValid = false;
        } else {

            $lastName = $this->formatInput($_POST["lastName"]);
            // check if only contains letters and whitespace
            if (!preg_match("/^([a-zA-Z' ]+)$/", $lastName)) {
                $this->registerMessages['lastName'] = 'Nom invalide.';
                $isValid = false;
            }
        }

        //username
        if (empty($_POST["username"])) {
            $this->registerMessages['username'] = 'Username obligatoire.';
            $isValid = false;
        } else {

            $username = $this->formatInput($_POST["username"]);
            // check username for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $this->registerMessages['username'] =  'Username invalide.';
                $isValid = false;
            }
        }

        //email
        if (empty($_POST["email"])) {
            $this->registerMessages['email'] = 'Email obligatoire.';
            $isValid = false;
        } else {

            $email = $this->formatInput($_POST["email"]);
            // check username for no space or .. or ._.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->registerMessages['email'] = 'Email invalide.';
                $isValid = false;
            }
        }
        //password
        if (empty($_POST["password"]) || empty($_POST["passwordConfirmation"])) {
            $this->registerMessages['password'] = 'Mot de passe obligatoire.';
            $isValid = false;
        } else {

            $password = stripslashes($_POST["password"]);
            $password = htmlspecialchars($password);
            $passwordConfirmation = stripslashes($_POST['passwordConfirmation']);
            $passwordConfirmation = htmlspecialchars($passwordConfirmation);
            // check username for no space or .. or ._.
            if ($password !== $passwordConfirmation) {
                $this->registerMessages['password'] = 'Mot de passe non identiques.';
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
