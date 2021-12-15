<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Models\DatabaseConnect;

use Framework\Controller\AbstractController;


class Profile extends AbstractController
{
    private $userInfo = [];
    private $updateMessages = [];
    private $pwdUpdateMessages = [];
    private $passwordPanelisActive = false;

    public function __invoke(): string
    {
        session_start();

        //redirect to homepage in case session exists
        if (!array_key_exists('username', $_SESSION) && empty($_SESSION['username'])) {
            $this->redirect('/');
        }
        // $_SESSION['username'] = 'nouaaman11';
        // $_SESSION['id'] = '6';

        $username =  $_SESSION['username'];
        $user = $this->getUserInfo($username);
        $this->displayUser($user);

        if ($this->isPost()) {
            if (isset($_POST['action']) && $_POST['action'] == 'updateAccount') {
                $username = $this->formatInput($_POST['username']);
                $exist = false;
                if ($this->checkExisting('username', $username)) {
                    $exist = true;
                    $this->updateMessages['username'] = 'Username existe deja.';
                };

                $email = $this->formatInput($_POST['email']);
                if ($this->checkExisting('email', $email)) {
                    $exist = true;
                    $this->updateMessages['email'] = 'Email existe deja.';
                };

                if (!$exist) {
                    $formData = $this->getModifiedData();
                    if ($formData != false) {
                        $user = new User();
                        $user->setFirstName($formData['firstName']);
                        $user->setLastName($formData['lastName']);
                        $user->setUsername($formData['username']);
                        $user->setEmail($formData['email']);

                        if ($this->updateUserAccount($user)) {
                            $_SESSION['username'] = $user->getUsername();
                            $this->updateMessages['message'] = 'Modification réussi.';
                            $this->updateMessages['status'] = true;
                            $user = $this->getUserInfo($username);
                            $this->displayUser($user);
                        } else {
                            $this->updateMessages['message'] = 'Échec de modification.';
                            $this->updateMessages['status'] = false;
                        }
                    }
                }
            } elseif (isset($_POST['action']) && $_POST['action'] == 'updatePassword') {
                $passwordFormData = $this->getModifiedPasswordData();
                if ($passwordFormData != false) {
                    $oldPassword = $passwordFormData['oldPassword'];
                    $newPassword = $passwordFormData['newPassword'];
                    if ($this->checkUserCredentials($oldPassword)) {
                        if ($this->updateUserPassword($newPassword)) {
                            $this->pwdUpdateMessages['message'] = 'Modification réussi.';
                            $this->pwdUpdateMessages['status'] = true;
                        } else {
                            $this->pwdUpdateMessages['message'] = 'Échec de modification.';
                            $this->pwdUpdateMessages['status'] = false;
                        }
                    } else {
                        $this->pwdUpdateMessages['oldPassword'] = 'Mot de passe Actuel est incorrect';
                    }
                }
                $this->passwordPanelisActive = true;
            }
            unset($_POST);
            
        }

        return $this->render('user/profile.html.twig', [
            'userInfo' => $this->userInfo,
            'updateMessages' => $this->updateMessages,
            'pwdUpdateMessages' => $this->pwdUpdateMessages,
            'passwordPanelisActive' => $this->passwordPanelisActive
        ]);
    }

    function checkUserCredentials(string $password): bool
    {
        $databaseconnect = new DatabaseConnect();
        $connection = $databaseconnect->GetConnection();
        $stmt = $connection->prepare('SELECT `password` from `User` WHERE `id`=:id');
        $stmt->bindParam(':id', $_SESSION['id'], \PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (isset($result['password']) && ($password == $result['password'])) {
                return true;
            }
            return false;
        }

        return false;
    }
    //return user data from database
    private function getUserInfo(string $username): User
    {
        try {

            $sql = "SELECT `id`,`username`,`email` ,`firstName`, `lastName`
            FROM `User`
            WHERE `username`=:username";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":username", $username, \PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$result) {
                session_destroy();
                $this->redirect('/');
            }
            $user = new User();
            $_SESSION['id'] = $result['id'];
            $user->setId((int)$result['id']);
            $user->setUsername($result['username']);
            $user->setEmail($result['email']);
            $user->setFirstName($result['firstName']);
            $user->setLastName($result['lastName']);

            return $user;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            exit($e->getMessage());
            return false;
        }
    }

    private function displayUser(User $user)
    {
        $this->userInfo['username'] = $user->getUsername();
        $this->userInfo['firstName'] = $user->getFirstName();
        $this->userInfo['lastName'] = $user->getLastName();
        $this->userInfo['email'] = $user->getEmail();
    }

    public function getModifiedData(): array|bool
    {
        $firstName = $lastName = $username = $email = '';
        $isValid = true;

        //first name 
        if (empty($_POST["firstName"])) {
            $this->updateMessages['firstName'] = 'Prenom obligatoire.';
            $isValid = false;
        } else {

            $firstName = $this->formatInput($_POST["firstName"]);
            // check if only contains letters and whitespace
            if (!preg_match("/^([a-zA-Z' ]+)$/", $firstName)) {
                $this->updateMessages['firstName'] = 'Prenom invalide.';
                $isValid = false;
            }
        }

        //last name
        if (empty($_POST["lastName"])) {
            $this->updateMessages['lastName'] = 'Nom obligatoire.';
            $isValid = false;
        } else {

            $lastName = $this->formatInput($_POST["lastName"]);
            // check if only contains letters and whitespace
            if (!preg_match("/^([a-zA-Z' ]+)$/", $lastName)) {
                $this->updateMessages['lastName'] = 'Nom invalide.';
                $isValid = false;
            }
        }

        //username
        if (empty($_POST["username"])) {
            $this->updateMessages['username'] = 'Username obligatoire.';
            $isValid = false;
        } else {

            $username = $this->formatInput($_POST["username"]);
            // check username for no space or .. or ._.
            if (!preg_match('/^[a-z\d_.-]{5,25}$/i', $username)) {
                $this->updateMessages['username'] =  'Username invalide.';
                $isValid = false;
            }
        }

        //email
        if (empty($_POST["email"])) {
            $this->updateMessages['email'] = 'Email obligatoire.';
            $isValid = false;
        } else {

            $email = $this->formatInput($_POST["email"]);
            // check username for no space or .. or ._.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->updateMessages['email'] = 'Email invalide.';
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
                'email' => $email
            ];
        }
    }

    public function getModifiedPasswordData(): array|bool
    {
        $oldPssword = $newPassword = '';
        $isValid = true;

        if (empty($_POST["oldPassword"])) {
            $this->pwdUpdateMessages['oldPassword'] = 'Mot de passe obligatoire.';
            $isValid = false;
        } else {
            $oldPssword = $_POST["oldPassword"];
        }

        if (empty($_POST["newPassword"]) || empty($_POST["newPasswordConfirmation"])) {
            $this->pwdUpdateMessages['newPassword'] = 'Mot de passe obligatoire.';
            $isValid = false;
        } else {

            $password = stripslashes($_POST["newPassword"]);
            $password = htmlspecialchars($password);
            $passwordConfirmation = stripslashes($_POST['newPasswordConfirmation']);
            $passwordConfirmation = htmlspecialchars($passwordConfirmation);
            // check username for no space or .. or ._.
            if ($password !== $passwordConfirmation) {
                $this->pwdUpdateMessages['newPassword'] = 'Mot de passe non identiques.';
                $isValid = false;
            } else {
                $newPassword = $_POST["newPassword"];
            }
        }

        if (!$isValid) {
            return false;
        } else {
            return [
                'oldPassword' => $oldPssword,
                'newPassword' => $newPassword
            ];
        }
    }

    public function updateUserPassword($newPassword)
    {
        try {
            $sql = "UPDATE `User` SET `password`=:newPassword WHERE `id` = :id";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":newPassword", $newPassword, \PDO::PARAM_STR);
            $stmt->bindParam(":id", $_SESSION['id'], \PDO::PARAM_STR);
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
    public function updateUserAccount(User $user)
    {

        try {

            $sql = "UPDATE `User` SET `firstName` = :firstName, `lastName` = :lastName, `username` = :username,`email` = :email
            WHERE `id` = :id";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":firstName", $user->getFirstName(), \PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $user->getLastName(), \PDO::PARAM_STR);
            $stmt->bindParam(":username", $user->getUsername(), \PDO::PARAM_STR);
            $stmt->bindParam(":email", $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindParam(":id", $_SESSION['id'], \PDO::PARAM_INT);

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
    /* check if user exists in db by column of choice*/
    public function checkExisting(string $searchBy, string $parameter): bool
    {
        try {
            $id = (int)$_SESSION['id'];
            $sql = "SELECT count(*) FROM `User` WHERE `{$searchBy}` = :parameter AND `id` != {$id}";
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
