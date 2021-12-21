<?php

namespace App\Controller\Admin\Reponses;

use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;



class Deleteresponse extends AbstractController
{

    private int $idAnswer;

    public function __invoke(int $id = null)
    {
        $this->idAnswer = (int)$id;

        if (!$this->checkExisting('id', (string)$this->idAnswer)) {
            $this->redirect('/admin/question/questions');
        } else {
            $this->deleteAnswer($this->idAnswer);
            echo '<script type="text/JavaScript"> 
            history.back();
                </script>';
        }
    }

    public function checkExisting(string $searchBy, string $parameter): bool
    {
        try {

            $sql = "SELECT count(*) FROM `Question` WHERE `{$searchBy}` = :parameter";
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
