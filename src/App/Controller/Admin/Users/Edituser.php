<?php

namespace App\Controller\Admin\Users;

use App\Entity\User;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Edituser extends AbstractController
{
    private $registerMessages = [];

    public function __invoke(int $id = null): string
    {
        $this->registerMessages;

        if ($this->isPost()) {
            if (isset($_POST['action']) && $_POST['action'] == 'editUser') {
                $username = $this->formatInput($_POST['username']);
                $exist = false;
                if ($this->checkExisting('username', $username)) {
                    $exist = true;
                    $this->registeMessages['username'] = 'Username existe deja.';
                    unset($_POST);
                    echo $username;
                    die;
                };

                if (!$exist) {
                    $formData = $this->getUpdateData();
                    if ($formData != false) {

                        $user = new User();
                        $user->setFirstName($formData['firstName']);
                        $user->setLastName($formData['lastName']);
                        $user->setUsername($formData['username']);
                        $user->setEmail($formData['email']);
                        $user->setPassword($formData['password']);
                        $this->updateUser($user, $id);

                        $_SESSION['username'] = $formData['username'];
                        unset($_POST);

                        $this->redirect('/admin/users');
                    }
                }
            }
        }
        return $this->render('admin/edituser.html.twig', [
            'user' =>  $this->displayUsers($id),
            'post' => $_POST,
            'registerMessage' => $this->registerMessages
        ]);
    }

    public function displayUsers($id)
    {
        try {

            $users = "SELECT * FROM User WHERE id = :id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($users);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch();
            return $results;
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return [];
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return [];
        }
        return [];
    }

    public function updateUser(User $user, int $id)
    {
        try {
            $users = "UPDATE User set username=:username WHERE id=:id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($users);
            $stmt->bindParam(':username', $user->getUsername(), \PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $this->redirect('/admin/users');
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            die;
            return [];
        } catch (\Throwable $e) {
            echo $e->getMessage();
            die;
            return [];
        }
        return [];
    }
    public function getUpdateData(): array|bool
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
    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
