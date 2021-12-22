<?php

namespace App\Controller\Admin\Reponses;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class AddReponse extends AbstractController
{
    public $registerMessages = [];

    public function __invoke(int $id = null)
    {

        $this->registerMessages;

        if (isset($_POST['action']) && $_POST['action'] == 'addAnswer') {
            $formDataAns = $this->getAnswerData();
            $rep = new Reponse();
            $rep->setLabel((string)$formDataAns['answerlabel']);
            echo ($id);
            $this->registerAnswer($rep, $id);
            $this->redirect('/admin/question/questions');
        }


        return $this->render(
            'admin/reponse/addreponse.html.twig',
            [
                'registerMessages' => $this->registerMessages,
                'post' => $_POST
            ]
        );
    }

    public function registerAnswer(Reponse $rep, $id)
    {
        try {
            $sql = "INSERT INTO `Answer` (`label`, `id_question`, `isValid`) 
            VALUES(:label, :idquest, :isvalid)";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":label", $rep->getLabel(), \PDO::PARAM_STR);
            $stmt->bindParam(":idquest", $id, \PDO::PARAM_STR);
            $stmt->bindParam(":isvalid", $rep->getValidity(), \PDO::PARAM_BOOL);
            $stmt->execute();
            return true;
            echo ($id);
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            exit($e->getMessage());
            return false;
        }
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
