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
