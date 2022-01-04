<?php

namespace App\Controller\Game;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class GameManager implements MessageComponentInterface
{
    // protected $clients;

    public function __construct() {
        echo '/n Manager /n';
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // $this->clients->attach($conn);
        echo 'someone connected at : ' .$conn->resourceId;
        
       
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo $msg;        
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    public function uid(){
        $uid = uniqid('game-');
        return $uid;
    }
}
