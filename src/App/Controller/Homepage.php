<?php

namespace App\Controller;

use Framework\Controller\AbstractController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

require '../vendor/autoload.php';


class Homepage extends AbstractController
{
    private $userIsConnected = false;
    private $username = '';
    private $role = '';

    public function __invoke(): string
    {
        session_start();

        if ($this->isPost() && isset($_POST['signOut'])) {
            session_destroy();
            $this->redirect('/');
        }
        //check if user is connected to show profile link and icons
        if (array_key_exists('username', $_SESSION) && !empty($_SESSION['username'])) {
            $this->userIsConnected = true;
            $this->username = $_SESSION['username'];
            $this->role = $_SESSION['role'];
        }

        return $this->render('home.html.twig', [
            'userIsConnected' => $this->userIsConnected,
            'username' => $this->username,
            'role' => $this->role,
            'mail' => $this->sendMail()
        ]);
    }

    public function sendMail()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';        // Enable SMTP authentication
        $mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
        $mail->Username = 'alexynouaaman@gmail.com'; // your email id
        $mail->Password = 'Admin-57160'; // your password
        $mail->setFrom('alexynouaaman@gmail.com');
        $mail->addAddress('gamereceipteur@gmail.com');   // Add a recipient
        $mail->isHTML(true);  // Set email format to HTML

        $bodyContent = '<h1>Bienvenue</h1>';
        $bodyContent .= '<p>Clique sur ce lien pour rejoindre la partie</p>';
        $mail->Subject = 'Invitation Board Game';
        $mail->Body    = $bodyContent;
        if (!$mail->send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            echo 'Email Sent.';
        }
    }
}
