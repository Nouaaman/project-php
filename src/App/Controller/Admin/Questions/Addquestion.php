<?php

namespace App\Controller\Admin\Questions;

use App\Entity\Question;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Addquestion extends AbstractController
{

    public $registerMessages = [];

    public function __invoke()
    {
        $this->registerMessages;

        if (isset($_POST['action']) && $_POST['action'] == 'addQuestion') {
            $label = $this->formatInput($_POST['label']);
            $exist = false;
            if ($this->checkExisting('label', $label)) {
                $exist = true;
                $this->registerMessages['label'] = 'Cette question existe deja.';
            };
            if (!$exist) {
                $formData = $this->getQuestionData();
                if ($formData != false) {
                    $quest = new Question();
                    $quest->setLabel($formData['label']);
                    $quest->setLevel((int)$formData['level']);
                    $this->registerQuestion($quest);
                    $this->redirect('/admin/question/questions');
                }
            }
        }

        return $this->render(
            'admin/question/addquestion.html.twig',
            [
                'registerMessages' => $this->registerMessages,
                'post' => $_POST
            ]
        );
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

    public function registerQuestion(Question $quest)
    {

        try {

            $sql = "INSERT INTO `Question` (`label`,`level`) 
            VALUES(:label,:levelquestion)";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":label", $quest->getLabel(), \PDO::PARAM_STR);
            $stmt->bindParam(":levelquestion", $quest->getLevel(), \PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            exit($e->getMessage());
            return false;
        }
    }
    public function getQuestionData(): array|bool
    {
        $label = $level = '';
        $isValid = true;

        //label question
        if (empty($_POST["label"])) {
            $this->registerMessages['label'] = 'Question obligatoire.';
            $isValid = false;
        } else {

            $label = $this->formatInput($_POST["label"]);
            // check question for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $label)) {
                $this->registerMessages['label'] =  'question invalide.';
                $isValid = false;
            }
        }

        //level question
        if (empty($_POST["level"])) {
            $this->registerMessages['level'] = 'Niveau obligatoire.';
            $isValid = false;
        } else {

            $level = $this->formatInput($_POST["level"]);
            // check question for no space or .. or ._.
            if (!preg_match('/^[1-6]*$/', $level)) {
                $this->registerMessages['level'] =  'Niveau invalide.';
                $isValid = false;
            }
        }

        if (!$isValid) {
            return false;
        } else {
            return [
                'label' => $label,
                'level' => $level
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
