<?php

namespace App\Controller\Game\Gamepage;

use App\Controller\Game\GameManager;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;



require __DIR__ . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new GameManager()
        )
    ),
    8282
);

$server->run();

