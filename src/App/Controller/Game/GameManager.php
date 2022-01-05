<?php

namespace App\Controller\Game;

require_once(__DIR__ . '/../../../../vendor/autoload.php');


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\DatabaseConnect;

require __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/../../../../vendor/autoload.php';


class GameManager implements MessageComponentInterface
{

    public $players;
    public $games;

    public function __construct()
    {
        $this->players = [];
        $this->games = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // echo 'someone connected at : ' . $conn->resourceId;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $result = json_decode($msg);
        if ($result != null) {
            //create game and set every player idgame 
            if ($result->method == 'create') {
                $usernames = []; //usernames of players to send  game link later
                $uidGame = $this->uid();
                foreach ($result->players as $player) {
                    $player->idGame = $uidGame;
                    array_push($usernames, $player->username);
                }
                array_push($this->players, $result->players);

                $game = (object)[
                    'idGame' => $uidGame,
                    'players' => $result->players
                ];

                array_push($this->games, $game);

                /*  
                //send mails
                // $host = $_SESSION['website_host'];

                // $gamelink = $host . "/game?idGame=" . $uidGame;
                $gamelink = "project-php/game?idGame=" . $uidGame;
                echo 'link : ' . $gamelink;
                $this->sendMail($this->getEmails($usernames), $gamelink);
                */
                //send idgame optional for test without mail
                $response = (object)[
                    'method' => 'create',
                    'idGame' => $uidGame
                ];
                $from->send(json_encode($response));
            }

            //player joigning game
            $gameToSend = null;
            if ($result->method == 'join') {
                foreach ($this->games as $game) {
                    if ($game->idGame == $result->idGame) {
                        foreach ($game->players as $player) {
                            if ($player->username == $result->username) {
                                $player->idConn = (object)$from;
                            }
                        }
                        $gameToSend =  $game;
                        break;
                    }
                }
                $this->updateGamePlayers($gameToSend);
            }
        }
    }

    public function updateGamePlayers($gameToSend)
    {
        $response = (object)[
            'method' => 'join',
            'game' => $gameToSend
        ];
        foreach ($this->games as $game) {
            if ($game->idGame == $gameToSend->idGame) {
                foreach ($game->players as $player) {
                    $player->idConn->send(json_encode($response));
                }
                break;
            }
        }
    }




    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    public function uid()
    {
        $uid = uniqid('game-');
        return $uid;
    }

    public function getEmails($usernames): array
    {
        $emails = [];
        foreach ($usernames as $username) {
            try {
                $sql = "SELECT `email` FROM `User` WHERE `username` = '" . $username . "' ";
                $databaseconnect = new DatabaseConnect();
                $connection = $databaseconnect->GetConnection();
                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchColumn();
                array_push($emails, $result);
            } catch (\Exception $ex) {
                exit($ex->getMessage());
                return false;
            } catch (\Throwable $e) {
                exit($e->getMessage());
                return false;
            }
        }


        return $emails;
    }

    public function sendMail($adresses, $gameLink)
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
        // $mail->addAddress('gamereceipteur@gmail.com');   // Add a recipient
        foreach ($adresses as $address) {
            $mail->addAddress($address);
        }

        $mail->isHTML(true);  // Set email format to HTML

        $bodyContent = '<h1>Bienvenue</h1>';
        $bodyContent .= '<p>Clique sur ce lien pour rejoindre la partie</p>';
        $bodyContent .= "<a href = '{$gameLink}' >lien</a>";
        $mail->Subject = 'Invitation Board Game';
        $mail->Body = $bodyContent;
        if (!$mail->send()) {
            echo 'Message was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            echo 'Email Sent.';
        }
    }
}
