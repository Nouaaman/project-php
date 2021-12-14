<?php

namespace App\Controller\Admin\Questions;

use App\Entity\Question;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Questions extends AbstractController
{
    public function __invoke()
    {
        return $this->render(
            'admin/question/questions.html.twig',
            [
                'questions' =>  $this->displayQuestions(),
                'reponses' =>  $this->displayAnswers(),
                /*                 'reponses' =>  $this->displayReponses($id),
 */                'countreponses' =>  $this->countReponses()

            ]
        );
    }

    public function displayQuestions()
    {
        try {
            $questions = "SELECT * FROM Question";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($questions);
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
    public function displayAnswers()
    {
        try {
            $reponses = "SELECT * FROM Answer";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($reponses);
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
    /*  public function displayReponses(Question $id)
    {
        try {
            $reponses = "SELECT r.label FROM Question q , Answer r , Question_reponse qr where qr.Id_question = :id and qr.Id_reponse = r.id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($reponses);
            $stmt->bindValue(':id', $id->getId(), \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
            var_dump($results);

            return $results;
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return [];
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return [];
        }
        return [];
    } */
    public function countReponses()
    {
        try {
            $countreponses = "SELECT COUNT(`id`) FROM Answer";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($countreponses);
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
}
