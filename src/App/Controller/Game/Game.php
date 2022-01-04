<?php

namespace App\Controller\Game;

use App\Entity\Question;
use App\Models\DatabaseConnect;
use Framework\Controller\AbstractController;

/* require 'PHPMailerAutoload.php';
 */

class Game extends AbstractController
{
    private $username = '';
    public function __invoke(): string
    {
        session_start();

        if (
            array_key_exists('username', $_SESSION)
            && !empty($_SESSION['username'])
        ) {
            $this->username = $_SESSION['username'];
        } else {
            $this->redirect('/login');
        }

        return $this->render('game/game.html.twig', [
            'username'=> $_SESSION['username'],
            'questions' =>  $this->displayQuestions(),
            /*             'mail' => $this->sendMail()
 */
        ]);
    }
    public function displayQuestions()
    {
        try {
            $questions = "SELECT * FROM Question WHERE level= 1
            ORDER BY RAND()
            LIMIT 1;";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($questions);
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
            echo ($results);
        } catch (\Exception $ex) {
            array_push($this->registerMessages, $ex->getMessage());
            return [];
        } catch (\Throwable $e) {
            array_push($this->registerMessages, $e->getMessage());
            return [];
        }
        return [];
    }

    /*     public function sendMail()
    {
        $mail = new PHPMailer;
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'example@gmail.com'; // your email id
        $mail->Password = 'password'; // your password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
        $mail->setFrom('alexychalopin@gmail.com', 'Chalopin');
        $mail->addAddress('alexynouaaman@gmail.com');   // Add a recipient
        $mail->isHTML(true);  // Set email format to HTML

        $bodyContent = '<h1>Test Mail</h1>';
        $bodyContent .= '<p>This is a email that Radhika send you From LocalHost using PHPMailer</p>';
        $mail->Subject = 'Email from Localhost by Radhika';
        $mail->Body    = $bodyContent;
        if (!$mail->send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
        }
    } */
}
