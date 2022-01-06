<?php

namespace App\Controller\Game;

require_once(__DIR__ . '/../../../../vendor/autoload.php');


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\DatabaseConnect;
use App\Entity\Question;
use App\Entity\Reponse;
use React\Dns\Model\Record;

require __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../../../vendor/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/../../../../vendor/autoload.php';

$configs = require  __DIR__ . '../../../../../config/app.local.php';
define('HOSTNAME', $configs['HOSTNAME']);

class GameManager implements MessageComponentInterface
{

    public $players;
    public $games;

    public function __construct()
    {
        $this->players = [];
        $this->games = [];
        echo 'Listening...';
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // echo 'someone connected at : ' . $conn->resourceId;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $result = json_decode($msg);
        if ($result != null) {

            /******************** create game and set every player idgame ***********************/
            if ($result->method == 'create') {
                $usernames = []; //usernames of players to send them game url
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

                $host = HOSTNAME;
                $gameURL = $host . "/game?idGame=" . $uidGame;
                echo "\n game created, URL => " . $gameURL . "\n";
                /*  
                //send mails
                
                $gamelink = "project-php/game?idGame=" . $uidGame;
                echo 'link : ' . $gamelink;
                $this->sendMail($this->getEmails($usernames), $gameURL);
                */
                //send idgame optional for test without mail
                $response = (object)[
                    'method' => 'create',
                    'idGame' => $uidGame
                ];
                $from->send(json_encode($response));
            }

            //player joigning game
            if ($result->method == 'join') {
                foreach ($this->games as $game) {
                    if ($game->idGame == $result->idGame) {
                        foreach ($game->players as $player) {

                            if ($player->username == $result->username) {
                                $player->conn = new \SplObjectStorage;
                                $player->conn->attach($from);
                                $player->isJoined = true;
                            }
                        }
                        $this->updateGamePlayers($game);
                        break;
                    }
                }
            }


            /******************** start game if all player joigned ***********************/
            if ($result->method == 'play') {
                // $totaPlayers = $result->game->players->count();
                // $i = 0;
                // foreach ($result->game->players as $player) {
                //     //turn of first player to play
                //     if ($i == 0) {
                //         $player->hisTurn = true;
                //         $i++;
                //     } else {
                //         $player->hisTurn = false;
                //     }
                // }
                $this->playGame($result->game);
            }


            /**************************** sync screens ***********************/
            if ($result->method == 'sync') {
                $this->syncScreens($from, $result->idGame, $result->phase, $result->validAnswerMessage);
            }


            /**************************** send question by level **************************/
            if ($result->method == 'getQuestion') {
                $level = (int)$result->level;
                $question = $this->getQuestion($level);
                $this->sendQuestion($result->idGame, $question);
            }

            /**************************** update player score **************************/
            if ($result->method == 'updateScore') {
                $this->updateScore($from, $result->idGame, $result->score);
                //change turn after updating player score
                $this->changePlayerTurn($result->idGame);
                //sending new game state
                foreach ($this->games as $game) {
                    if ($game->idGame == $result->idGame) {
                        $this->playGame($game);
                        break;
                    }
                }
            }
        }
    }


    //show players line
    public function updateGamePlayers($gameToSend)
    {
        $response = (object)[
            'method' => 'join',
            'game' => $gameToSend
        ];
        foreach ($this->games as $game) {
            if ($game->idGame == $gameToSend->idGame) {
                foreach ($game->players as $player) {
                    foreach ($player->conn as $conn) {
                        $conn->send(json_encode($response));
                    }
                }
                break;
            }
        }
    }

    //play if all player joined
    public function playGame($gameToSend)
    {
        $response = (object)[
            'method' => 'play',
            'game' => $gameToSend
        ];
        foreach ($this->games as $game) {
            if ($game->idGame == $gameToSend->idGame) {
                foreach ($game->players as $player) {
                    foreach ($player->conn as $conn) {
                        $conn->send(json_encode($response));
                    }
                }
                break;
            }
        }
    }

    //sync screen data or phase of game for all players
    public function syncScreens($from, $idGameToSync, $phase, $validAnswerMessage)
    {
        $response = (object)[
            'method' => 'sync',
            'game' => $idGameToSync,
            'phase' => $phase,
            'validAnswerMessage' => $validAnswerMessage
        ];
        foreach ($this->games as $game) {
            if ($game->idGame == $idGameToSync) {
                foreach ($game->players as $player) {
                    foreach ($player->conn as $conn) {
                        if ($conn != $from) {
                            $conn->send(json_encode($response));
                        }
                    }
                }
                break;
            }
        }
    }

    //send question to players
    public function sendQuestion($idGameToSync, object $question)
    {
        $response = (object)[
            'method' => 'getQuestion',
            'game' => $idGameToSync,
            'question' => $question
        ];
        foreach ($this->games as $game) {
            if ($game->idGame == $idGameToSync) {
                foreach ($game->players as $player) {
                    foreach ($player->conn as $conn) {

                        $conn->send(json_encode($response));
                    }
                }
                break;
            }
        }
    }

    public function getQuestion($level): object
    {
        $questionAnswers = (object)[
            // 'question' => 
            // 'answers' => 
        ];
        $question = new Question;

        //get random question by level
        try {
            $sql = "SELECT * FROM `Question` WHERE `level` = " . $level . " ORDER BY RAND() LIMIT 1";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            $question->setId((int)$result['id']);
            $question->setLabel($result['label']);
            $question->setLevel((int)$result['level']);
            $questionAnswers->question = $question->getLabel();
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        } catch (\Throwable $e) {
            exit($e->getMessage());
        }

        //get answers of the question 
        try {
            $sql = "SELECT * FROM `Answer` WHERE `id_question` = " . $question->getId() . "";
            $databaseconnect = new DatabaseConnect();
            $connection = $databaseconnect->GetConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $arrayOfanswers = [];
            foreach ($result as $asw) {
                $answer = (object)[
                    'label' => $asw['label'],
                    'isValid' => $asw['isValid']
                ];
                array_push($arrayOfanswers, $answer);
            }
            $questionAnswers->answers = $arrayOfanswers;
        } catch (\Exception $ex) {
            exit($ex->getMessage());
        } catch (\Throwable $e) {
            exit($e->getMessage());
        }

        return $questionAnswers;
    }

    function updateScore($from, $idGame, $score)
    {
        foreach ($this->games as $game) {
            if ($game->idGame == $idGame) {
                foreach ($game->players as $player) {
                    if ($player->conn == $from) {
                        $player->score = $score;
                    }
                }
                break;
            }
        }
    }

    function changePlayerTurn($idGame)
    {
        $nbrOfPlayers = 0;
        $currentPlayerTurn = 0;
        foreach ($this->games as $game) {
            if ($game->idGame == $idGame) {
                //count total players
                foreach ($game->players as $player) {
                    $nbrOfPlayers++;
                }
                if ($nbrOfPlayers == 2) {
                    if ($game->players[0]->hisTurn == true) {
                        $game->players[0]->hisTurn = false;
                        $game->players[1]->hisTurn = true;
                    } else {
                        $game->players[0]->hisTurn = true;
                        $game->players[1]->hisTurn = false;
                    }
                } else {
                    for ($i = 0; $i < $nbrOfPlayers; $i++) {
                        if ($game->players[$i]->hisTurn == true) {
                            if ($i < $nbrOfPlayers - 1) {
                                $game->players[$i]->hisTurn = false;
                                $game->players[$i + 1]->hisTurn = true;
                            } else {
                                $game->players[$nbrOfPlayers - 1]->hisTurn = false;
                                $game->players[0]->hisTurn = true;
                            }
                        }
                    }
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

    //return array of emails of players by given usernames
    public function getEmails(array $usernames): array
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

    public function sendMail(array $adresses, $gameLink)
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
