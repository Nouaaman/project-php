<?php

namespace App\Controller\Game;

require_once(__DIR__ . '/../../../../vendor/autoload.php');


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
