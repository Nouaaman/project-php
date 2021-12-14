<?php

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
<<<<<<< HEAD
    new Route(['GET', 'POST'], 'user/profile', Profile::class),
    new Route('GET', '/admin/users/delete/{id}', Users::class),
=======
    
    new Route('GET', '/admin/users/{operation}/{id}', Users::class),
>>>>>>> 0171e57514406026622c571a081427a273db8058
    new Route(['GET', 'POST'], '/login', Login::class),
    new Route(['GET', 'POST'], '/admin/users', Users::class),
    new Route(['GET', 'POST'], '/admin/question/questions', Questions::class),
    new Route(['GET', 'POST'], '/admin/question/addquestions', Addquestion::class),
    new Route(['GET', 'POST'], '/admin/question/editquestions', Editquestion::class),
    new Route(['GET', 'POST'], '/admin/reponse/reponses', Reponses::class),
    new Route(['GET', 'POST'], '/admin/reponse/addreponse', AddReponse::class),
    new Route(['GET', 'POST'], '/admin/reponse/editreponse', EditReponse::class),
    new Route(['GET', 'POST'], '/admin/adduser', Adduser::class),
<<<<<<< HEAD
    new Route(['GET', 'POST'], '/admin/edituser/{id}', Edituser::class),

=======
    new Route(['GET', 'POST'], '/user/profile', Profile::class),
>>>>>>> 0171e57514406026622c571a081427a273db8058
    new Route('GET', '/404', Page404::class),

];
