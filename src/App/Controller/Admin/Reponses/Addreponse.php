<?php

namespace App\Controller\Admin\Reponses;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

class Addreponse extends AbstractController
{
    public $registerMessages = [];


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

            $this->username = $_SESSION['username'];
        } else {
            $this->redirect('/');
        }

        if (isset($_POST['action']) && $_POST['action'] == 'addAnswer') {
            $formDataAns = $this->getAnswerData();
            if ($formDataAns != false) {
                $rep = new Reponse();
                $rep->setLabel($formDataAns['answerlabel']);
                $rep->setIdquestion($id);
                $rep->setIsValid($formDataAns['validAnswer']);
                $this->registerAnswer($rep);
                $this->redirect('/admin/question/questions');
            }
        }


        return $this->render(
            'admin/reponse/addreponse.html.twig',
            [
                'registerMessages' => $this->registerMessages,
                'post' => $_POST
            ]
        );
    }

    public function registerAnswer(Reponse $rep)
    {
        try {
            $sql = "INSERT INTO `Answer` (`label`, `id_question`, `isValid`) 
            VALUES(:label, :idquest, :isvalid)";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":label", $rep->getLabel());
            $stmt->bindParam(":idquest", $rep->getIdquestion(), \PDO::PARAM_INT);
            $stmt->bindParam(":isvalid", $rep->getIsValid(), \PDO::PARAM_BOOL);
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

    public function getAnswerData(): array|bool
    {
        $labelAnswer = $CorrectAns = '';
        $isValid = true;

        //label answer
        if (empty($_POST["answerlabel"])) {
            $this->registerMessages['answerlabel'] = 'Réponse obligatoire.';
            $isValid = false;
        } else {

            $labelAnswer = $this->formatInput($_POST["answerlabel"]);
            // check question for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $labelAnswer)) {
                $this->registerMessages['answerlabel'] =  'réponse invalide.';
                $isValid = false;
            }
        }
        if (isset($_POST['validAnswer']) && $_POST['validAnswer'] == "true") { //where "Value" is the
            //same string given in the HTML form, as value attribute the the checkbox input
            $CorrectAns = true;
        } else {
            $CorrectAns = false;
        }
        if (!$isValid) {
            return false;
        } else {
            return [
                'answerlabel' => $labelAnswer,
                'validAnswer' => $CorrectAns

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
