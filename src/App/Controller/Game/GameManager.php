<?php

namespace App\Controller\Game;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use App\Entity\Player;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

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
                $uidGame = $this->uid();
                foreach ($result->players as $player) {
                    $player->idGame = $uidGame;
                }
                array_push($this->players, $result->players);

                $game = (object)[
                    'idGame' => $uidGame,
                    'players' => $result->players
                ];

                array_push($this->games, $game);
                //send idgame
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
                                $player->idConn = $from;
                            }
                        }
                        break;
                    }
                }

                $response = (object)[
                    'method' => 'join',
                    'msg' => 'you id is : ' . $from->resourceId
                ];
                $from->send(json_encode($response));
            }
        }
    }

    public function updateGameState(){
        
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
}
