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
use App\Controller\Admin\Reponses\AddReponse;
use App\Controller\Homepage;
use App\Controller\User\Login;
use App\Controller\Page404;
use App\Controller\User\Profile;
use Framework\Routing\Route;



return [
    new Route(['GET', 'POST'], '/', Homepage::class),
    new Route('GET', '/admin/users/delete/{id}', Users::class),
    new Route('GET', '/admin/users/{operation}/{id}', Users::class),
    new Route(['GET', 'POST'], '/login', Login::class),
    new Route(['GET', 'POST'], '/admin/users', Users::class),
    new Route(['GET', 'POST'], '/admin/question/questions', Questions::class),
    new Route(['GET', 'POST'], '/admin/question/addquestion', Addquestion::class),
    new Route(['GET', 'POST'], '/admin/question/editquestion', Editquestion::class),
    new Route(['GET', 'POST'], '/admin/question/delete/{id}', Questions::class),
    new Route(['GET', 'POST'], '/admin/reponse/reponses/{id}', Reponses::class),
    new Route(['GET', 'POST'], '/admin/reponse/delete/{id}', Reponses::class),
    new Route(['GET', 'POST'], '/admin/reponse/addreponse', AddReponse::class),
    new Route(['GET', 'POST'], '/admin/reponse/editreponse', EditReponse::class),
    new Route(['GET', 'POST'], '/admin/adduser', Adduser::class),
    new Route(['GET', 'POST'], '/admin/edituser/{id}', Edituser::class),

    new Route(['GET', 'POST'], '/user/profile', Profile::class),
    new Route('GET', '/admin/homepage', Adminhomepage::class),
    new Route('GET', '/404', Page404::class),

];
