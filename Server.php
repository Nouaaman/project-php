<?php

namespace App\Controller\Game\Gamepage;

use App\Controller\Game\GameManager;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;

require __DIR__ . '/vendor/autoload.php';


// $server = IoServer::factory(
//     new GameManager(),
//     2222
// );
$ws = new WsServer(new GameManager());

// Make sure you're running this as root
$server = IoServer::factory(new HttpServer($ws));
$server->run();
//run as root
