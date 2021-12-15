<?php

namespace App\Controller\Admin\Users;

use App\Entity\User;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Edituser extends AbstractController
{
    private $updateMessages = [];

    public function __invoke(int $id = null): string
    {
        session_start();
        /*if (!array_key_exists('username', $_SESSION) && empty($_SESSION['username'])) {
            $this->redirect('/');
        } */
        $_SESSION['id'] = $id;

        if ($this->isPost()) {
            if (isset($_POST['action']) && $_POST['action'] == 'editUser') {
                $username = $this->formatInput($_POST['username']);
                $exist = false;

                if ($this->checkExisting('username', $username)) {
                    $exist = true;
                    $this->registeMessages['username'] = 'Username existe deja.';
                };

                $email = $this->formatInput($_POST['email']);
                if ($this->checkExisting('email', $email)) {
                    $exist = true;
                    $this->updateMessages['email'] = 'Email existe deja.';
                };
                if (!$exist) {
                    $formData = $this->getUpdateData();
                    if ($formData != false) {

                        $user = new User();
                        $user->setRole($formData['role']);
                        $user->setFirstName($formData['firstName']);
                        $user->setLastName($formData['lastName']);
                        $user->setUsername($formData['username']);
                        $user->setEmail($formData['email']);
                        $user->setPassword($formData['password']);
                        // $this->updateUser($user, $id);
                        if ($this->updateUser($user, $id)) {
                            $_SESSION['username'] = $user->getUsername();
                            $this->updateMessages['message'] = 'Modification réussi.';
                        } else {
                            echo 'erreur';
                            die;
                        }

                        $_SESSION['username'] = $formData['username'];
                        unset($_POST);

                        $this->redirect('/admin/users');
                    }
                }
            }
        }

        $user = $this->displayUser($id);
        // var_dump($this->updateMessages);
        // die;
        return $this->render('admin/edituser.html.twig', [
            'user' =>  $user,
            'updateMessages' => $this->updateMessages
        ]);
    }

    public function displayUser($id)
    {
        try {
            $users = "SELECT * FROM User WHERE id = :id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($users);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $results;
        } catch (\Exception $ex) {
            array_push($this->updateMessages, $ex->getMessage());
            return [];
        } catch (\Throwable $e) {
            array_push($this->updateMessages, $e->getMessage());
            return [];
        }
        return [];
    }

    public function updateUser(User $user, $id)
    {
        try {
            $users = "UPDATE `User` SET `firstName` = :firstName, `lastName` = :lastName,
             `username` = :username,`email` = :email, `password` = :newPassword, `roles` = :roles WHERE `id` = :id";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($users);

            $stmt->bindParam(":firstName", $user->getFirstName(), \PDO::PARAM_STR);
            $stmt->bindParam(":lastName", $user->getLastName(), \PDO::PARAM_STR);
            $stmt->bindParam(":username", $user->getUsername(), \PDO::PARAM_STR);
            $stmt->bindParam(":email", $user->getEmail(), \PDO::PARAM_STR);
            $stmt->bindParam(":newPassword", $user->getPassword(), \PDO::PARAM_STR);
            $stmt->bindParam(":roles", $user->getRole(), \PDO::PARAM_STR);
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
        $firstName = $lastName = $username = $email = $password = $passwordConfirmation = $role = '';
        $isValid = true;

        //Role 
        if (empty($_POST["role"])) {
            $this->updateMessages['role'] = 'Role invalid.';
            $isValid = false;
        } else {

            $role = $this->formatInput($_POST["role"]);
            // check if only contains letters and whitespace
            if ($role !== 'user' && $role !== 'admin') {
                $this->updateMessages['role'] = 'Role invalid.';
                $isValid = false;
            }
        }
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
            if (!preg_match("/^[a-z\d_.-]{5,25}$/i", $username)) {
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
        //password
        if (empty($_POST["password"]) || empty($_POST["passwordConfirmation"])) {
            $this->updateMessages['password'] = 'Mot de passe obligatoire.';
            $isValid = false;
        } else {

            $password = stripslashes($_POST["password"]);
            $password = htmlspecialchars($password);
            $passwordConfirmation = stripslashes($_POST['passwordConfirmation']);
            $passwordConfirmation = htmlspecialchars($passwordConfirmation);
            // check username for no space or .. or ._.
            if ($password !== $passwordConfirmation) {
                $this->updateMessages['password'] = 'Mot de passe non identiques.';
                $isValid = false;
            }
        }
        if (!$isValid) {
            return false;
        } else {
            return [
                'role' => $role,
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
