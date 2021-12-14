<?php

namespace App\Controller\Admin\Questions;

use App\Entity\Question;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Questions extends AbstractController
{
    public function __invoke(int $id = null)
    {
        return $this->render(
            'admin/question/questions.html.twig',
            [
                'questions' =>  $this->displayQuestions(),
                'reponses' =>  $this->displayAnswers(),
                'countreponses' =>  $this->countReponses($id)

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

    public function countReponses($id)
    {
        try {
            $countreponses = "SELECT COUNT(a.id) FROM Answer a, Question q WHERE q.id = a.id_question AND q.id=:id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($countreponses);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
            var_dump($results);
            die;
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
