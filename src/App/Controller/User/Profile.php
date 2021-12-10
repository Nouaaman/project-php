<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Models\DatabaseConnect;

use Framework\Controller\AbstractController;


class Profile extends AbstractController
{
    private $userInfo = [];

    public function __invoke(): string
    {
        session_start();

        //redirect to homepage in case session exists
        /* if (array_key_exists('username', $_SESSION) && !empty($_SESSION['username'])) {
            $this->redirect('/');
        } */
        $_SESSION['username'] = 'nouaaman11';
        $_SESSION['id'] = '6';

        $username =  $_SESSION['username'];
        $user = $this->getUserInfo($username);
        $this->displayUser($user);

        return $this->render('user/profile.html.twig', [
            'userInfo' => $this->userInfo
        ]);
    }

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

            $user = new User();
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


    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
