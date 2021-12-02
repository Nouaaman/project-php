<?php

use App\Controller\Homepage;
use App\Controller\Page;
use App\Controller\Question;
use App\Controller\SignIn;
use App\Controller\User\Register;
use Framework\Routing\Route;



return [
    new Route('GET', '/', Homepage::class),
    new Route('GET', '/question/{id}', Question::class),
    new Route('GET', '/page', Page::class),
    new Route('GET', '/login', SignIn::class),
    new Route(['GET', 'POST'], '/register', Register::class),
];
