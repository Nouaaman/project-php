<?php

namespace App\Controller\Admin\Reponses;

use App\Entity\Question;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Reponses extends AbstractController
{
    public function __invoke(int $id = null): string
    {
        $this->deleteReponse($id);
        return $this->render(
            'admin/reponse/reponses.html.twig',
            ['reponses' =>  $this->displayReponses($id)]
        );
    }

    public function displayReponses($id)
    {
        try {

            $reponses = "SELECT * FROM Answer WHERE id_question=$id";
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


    public function deleteReponse($id)
    {
        try {
            $users = "DELETE FROM Answer WHERE id=$id";
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

    public function getAnswerData(): array|bool
    {
        $labelAnswer = $valid = '';
        $isValid = true;

        //label answer
        if (empty($_POST["labelAnswer"])) {
            $this->registerMessages['label'] = 'Réponse obligatoire.';
            $isValid = false;
        } else {

            $labelAnswer = $this->formatInput($_POST["labelAnswer"]);
            // check question for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $labelAnswer)) {
                $this->registerMessages['label'] =  'question invalide.';
                $isValid = false;
            }
        }

        if (!$isValid) {
            return false;
        } else {
            return [
                'labelAnswer' => $labelAnswer
                /*                 'level' => $level
 */
            ];
        }
    }
    public function formatInput($inputData)
    {
        $inputData = trim($inputData);
        $inputData = stripslashes($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
}
