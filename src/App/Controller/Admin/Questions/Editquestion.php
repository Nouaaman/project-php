<?php

namespace App\Controller\Admin\Questions;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;
use Stringable;

class Editquestion extends AbstractController
{

    private $questionUpdateMessages = [];
    private $answerUpdateMessages = [];
    private int $idQuestion;
    private Question $question;
    private $answersArray = [];

    public function __invoke(int $id = null)
    {
        /* $this->registerMessages;

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
 */


        $this->idQuestion = (int)$id;

        if (!$this->checkExisting('id', (string)$this->idQuestion)) {
            $this->redirect('/admin/question/questions');
        }

        $this->question = $this->getQuestion($this->idQuestion);
        $this->answersArray = $this->getAnswers($this->idQuestion);

        return $this->render(
            'admin/question/editquestion.html.twig',
            [
                'question' => $this->question,
                'post' => $_POST,
                'answersArray' => $this->answersArray
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
    //get question fron db by id
    public function getQuestion(int $id): Question|false
    {
        try {
            $sql = "SELECT * FROM Question WHERE id = :id";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $results = $stmt->fetch(\PDO::FETCH_ASSOC);
            $question = new Question();
            $question->setId((int)$results['id']);
            $question->setLabel($results['label']);
            $question->setLevel($results['level']);

            return $question;
        } catch (\Exception $ex) {
            // array_push($this->registerMessages, $ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            // array_push($this->registerMessages, $e->getMessage());
            return false;
        }
        return false;
    }

    //get answers fron db by id of question
    public function getAnswers(int $idQuestion): array|false
    {
        try {
            $sql = "SELECT * FROM Answer WHERE id_question = :idQuestion";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':idQuestion', $idQuestion);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $results;
        } catch (\Exception $ex) {
            // array_push($this->registerMessages, $ex->getMessage());
            return false;
        } catch (\Throwable $e) {
            // array_push($this->registerMessages, $e->getMessage());
            return false;
        }
        return false;
    }




    public function updateQuestion(Question $quest)
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


    public function UpdateAnswer(Reponse $rep)
    {

        try {

            $sql = "INSERT INTO `Answer` (`label`, :idquest,`level`) 
            VALUES(:label, :idquest, :isvalid)";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(":label", $rep->getLabel(), \PDO::PARAM_STR);
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

    public function getQuestionFromForm(): Question|bool
    {
        $question = new Question();
        $question->setId($this->idQuestion);
        $isValid = true;

        //label question
        if (empty($_POST["labelQuestion"])) {
            $this->registerMessages['label'] = 'Question obligatoire.';
            $isValid = false;
        } else {

            $label = $this->formatInput($_POST["labelQuestion"]);
            // check question for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $label)) {
                $this->registerMessages['labelQuestion'] =  'Question invalide.';
                $isValid = false;
            } else {
                $question->setLabel($label);
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
            } else {
                $question->setLevel($level);
            }
        }

        if (!$isValid) {
            return false;
        } else {
            return $question;
        }
    }

    public function getAnswersFromForm(): Question|bool
    {
        $question = new Question();
        $question->setId($this->idQuestion);
        $isValid = true;

        //label question
        if (empty($_POST["labelQuestion"])) {
            $this->registerMessages['label'] = 'Question obligatoire.';
            $isValid = false;
        } else {

            $label = $this->formatInput($_POST["labelQuestion"]);
            // check question for no space or .. or ._.
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $label)) {
                $this->registerMessages['labelQuestion'] =  'Question invalide.';
                $isValid = false;
            } else {
                $question->setLabel($label);
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
            } else {
                $question->setLevel($level);
            }
        }

        if (!$isValid) {
            return false;
        } else {
            return $question;
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
