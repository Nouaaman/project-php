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
    private $answerUpdateMessages = '';
    private int $idQuestion;
    private Question $question;
    private $answersArray = [];

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
            $this->userIsConnected = true;
            $this->username = $_SESSION['username'];
        } else {
            $this->redirect('/');
        }


        $this->idQuestion = (int)$id;

        if (!$this->checkExisting('id', (string)$this->idQuestion)) {
            $this->redirect('/admin/question/questions');
        }

        //if post update question and answers
        if ($this->isPost()) {
            $isValid = true;
            $question = $this->getQuestionFromForm();
            $answersArray = $this->getAnswersFromForm();
            if ($question != false) {
                $this->updateQuestion($question);
            }
            if ($answersArray != false) {
                foreach ($answersArray as $answer) {
                    $this->UpdateAnswer($answer);
                }
            }
        }

        //get data to display
        $this->question = $this->getQuestion($this->idQuestion);
        $this->answersArray = $this->getAnswers($this->idQuestion);


        return $this->render(
            'admin/question/editquestion.html.twig',
            [
                'question' => $this->question,
                'answersArray' => $this->answersArray,
                'questionMessages' => $this->questionUpdateMessages,
                'answersMessages' => $this->answerUpdateMessages
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
    }




    public function updateQuestion(Question $quest)
    {

        try {

            $sql = "UPDATE `Question` SET `label` = :label , `level` = :levelquestion
            WHERE id = :id";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);

            $stmt->bindValue(":id", $quest->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(":label", $quest->getLabel(), \PDO::PARAM_STR);
            $stmt->bindValue(":levelquestion", $quest->getLevel(), \PDO::PARAM_INT);

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

            $sql = "UPDATE `Answer` SET `label` = :label , isValid = :isValid 
            WHERE id = :id";

            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $rep->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(":label", $rep->getLabel(), \PDO::PARAM_STR);
            $stmt->bindValue(":isValid", $rep->getisValid(), \PDO::PARAM_BOOL);
            $stmt->execute();

            return true;
        } catch (\Exception $ex) {
            /*             exit($ex->getMessage());
 */
            return false;
        } catch (\Throwable $e) {
            /*             exit($e->getMessage());
 */
            return false;
        }
    }

    //get auestion from form , return false if not valid
    public function getQuestionFromForm(): Question|bool
    {
        $question = new Question();
        $question->setId($this->idQuestion);
        $isValid = true;

        //label question
        if (empty($_POST["questionLabel"])) {
            $this->questionUpdateMessages['label'] = 'Question obligatoire.';
            $isValid = false;
        } else {

            $label = $this->formatInput($_POST["questionLabel"]);
            // check question for no space or .. or ._.
            $question->setLabel($label);
        }


        //level question
        if (empty($_POST["questionLevel"])) {
            $this->questionUpdateMessages['level'] = 'Niveau obligatoire.';
            $isValid = false;
        } else {

            $level = $this->formatInput($_POST["questionLevel"]);
            // check question for no space or .. or ._.
            if (!preg_match('/^[1-6]*$/', $level)) {
                $this->questionUpdateMessages['level'] =  'Niveau invalide.';
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

    //get answers from form , return array of answers else false if not valid
    public function getAnswersFromForm(): array|bool
    {

        $isValid = true;
        $answersArray = [];
        $correctAnswersId = [];
        $i = 0;

        //get correct answers
        foreach ($_POST["correctAnswer"] as $ca) {
            $correctAnswersId[] = $this->formatInput($ca);
        }

        foreach ($_POST["answerId"] as $id) {
            if (empty($_POST["answerLabel"][$i])) {
                $this->answerUpdateMessages = 'Tous les reponses doivent etre inserees';
                $isValid = false;
                break;
            } else {
                $answer = new Reponse();
                $answer->setId($this->formatInput((int)$id));
                $answer->setLabel($this->formatInput($_POST["answerLabel"][$i]));
                in_array($id, $correctAnswersId) ? $answer->setisValid(true) : $answer->setisValid(false);
                $answersArray[] = $answer;
                $i++;
            }
        }

        if (!$isValid) {
            return false;
        } else {
            return $answersArray;
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
