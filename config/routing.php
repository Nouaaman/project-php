<?php

use App\Controller\Homepage;
use App\Controller\Page;
use App\Controller\Question;
use App\Controller\User\Login;
use App\Controller\Page404;
use App\Controller\User\Register;
use Framework\Routing\Route;



return [
    new Route('GET', '/', Homepage::class),
    new Route('GET', '/question/{id}', Question::class),
    new Route('GET', '/page', Page::class),
    new Route(['GET', 'POST'], '/login', Login::class),
    new Route('GET', '/404', Page404::class),
    new Route(['GET', 'POST'], '/register', Register::class),
];
