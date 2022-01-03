<?php

namespace App\Controller\Game\Gamepage;

use App\Controller\Game\GameManager;
use Ratchet\Server\IoServer;

// require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new GameManager(),
    8080
);

$server->run();
