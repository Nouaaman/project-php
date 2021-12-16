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
}
