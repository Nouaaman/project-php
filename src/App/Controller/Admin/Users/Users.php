<?php

namespace App\Controller\Admin\Users;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Users extends AbstractController
{
    public function __invoke(int $id = null): string
    {
        session_start();
        //check if user is connected and admin
        if (
            array_key_exists('username', $_SESSION)
            && !empty($_SESSION['username'])
            && !empty($_SESSION['role'])
            && $_SESSION['role'] == 'admin'
        ) {
            $this->userIsConnected = true;
            $this->username = $_SESSION['username'];
        } else {
            $this->redirect('/');
        }

        if ($id != null) {
            $this->delete($id);
        }
        return $this->render(
            'admin/user/users.html.twig',
            [
                'users' =>  $this->displayUsers(),
                'username' => $this->username
            ]
        );
    }


    public function displayUsers()
    {
        try {

            $users = "SELECT * FROM User";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($users);
            $stmt->execute();
            $results = $stmt->fetchAll();
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

    public function delete($id)
    {
        try {
            $users = "DELETE FROM User WHERE id=$id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($users);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
            $this->redirect('/admin/users');
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return [];
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return [];
        }
        return [];
    }
}
