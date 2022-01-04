<?php

use App\Controller\Admin\Adminhomepage;
use App\Controller\Admin\Users\Users;
use App\Controller\Admin\Users\Adduser;
use App\Controller\Admin\Users\Edituser;
use App\Controller\Admin\Questions\Questions;
use App\Controller\Admin\Questions\Addquestion;
use App\Controller\Admin\Questions\Editquestion;
use App\Controller\Admin\Reponses\Reponses;
use App\Controller\Admin\Reponses\EditReponse;
use App\Controller\Admin\Reponses\Addreponse;
use App\Controller\Admin\Reponses\Deleteresponse;
use App\Controller\Homepage;
use App\Controller\User\Login;
use App\Controller\Page404;
use App\Controller\User\Profile;
use App\Controller\Game\Create;
use App\Controller\Game\Begin;
use App\Controller\Game\Game;
use App\Controller\Game\Searchplayer;
use Framework\Routing\Route;



return [
    new Route(['GET', 'POST'], '/', Homepage::class),
    new Route(['GET', 'POST'], '/login', Login::class),
    new Route('GET', '/404', Page404::class),
    /* admin */
    new Route('GET', '/admin/users/delete/{id}', Users::class),
    new Route('GET', '/admin/users/{operation}/{id}', Users::class),
    new Route(['GET', 'POST'], '/admin/users', Users::class),
    new Route(['GET', 'POST'], '/admin/question/questions', Questions::class),
    new Route(['GET', 'POST'], '/admin/question/add', Addquestion::class),
    new Route(['GET', 'POST'], '/admin/question/edit/{id}', Editquestion::class),
    new Route(['GET', 'POST'], '/admin/question/delete/{id}', Questions::class),
    new Route(['GET', 'POST'], '/admin/reponse/reponses/{id}', Reponses::class),
    new Route(['GET', 'POST'], '/admin/reponse/add/{id}', Addreponse::class),
    new Route(['GET', 'POST'], '/admin/reponse/editreponse', EditReponse::class),
    new Route(['GET', 'POST'], '/admin/adduser', Adduser::class),
    new Route(['GET', 'POST'], '/admin/edituser/{id}', Edituser::class),
    new Route(['GET', 'POST'], '/admin/reponse/delete/{id}', Deleteresponse::class),
    new Route(['GET', 'POST'], '/user/profile', Profile::class),
    new Route('GET', '/admin/homepage', Adminhomepage::class),
    /* game*/
    new Route('GET', '/game/create', Create::class),
    new Route('GET', '/game/begin', Begin::class, Searchplayer::class),
    new Route('GET', '/game', Game::class),

    /*searchPlayer autocomplete */
    new Route(['GET', 'POST'], '/game/searchplayer', Searchplayer::class)
];
