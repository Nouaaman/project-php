<?php

namespace App\Controller\Admin\Users;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Users extends AbstractController
{
    public function __invoke(int $id = null): string
    {
        session_start();
        if (!array_key_exists('username', $_SESSION) && empty($_SESSION['username'])) {
            $this->redirect('/');
        }

        if ($id != null) {
            $this->delete($id);
        }
        return $this->render(
            'admin/users.html.twig',
            ['users' =>  $this->displayUsers()]
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
