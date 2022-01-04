<?php

namespace App\Controller\Game;

// require_once(__DIR__ . '/../vendor/autoload.php');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class GameManager implements MessageComponentInterface
{
    public function onOpen(ConnectionInterface $conn)
    {
        echo 'someone connected at : ' . $conn;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }
}
