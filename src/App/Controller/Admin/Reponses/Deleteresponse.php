<?php

namespace App\Controller\Admin\Reponses;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;



class Deleteresponse extends AbstractController
{

    private int $idAnswer;

    public function __invoke(int $id = null)
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


        $this->idAnswer = (int)$id;

        $this->deleteAnswer($this->idAnswer);
        $this->redirect('/admin/question/questions');
    }

    public function deleteAnswer(int $id)
    {
        try {
            $question = "DELETE FROM Answer WHERE id=$id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($question);
            $stmt->execute();
            return true;
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return false;
        }
    }
}
