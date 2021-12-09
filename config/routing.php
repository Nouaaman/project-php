<?php

use App\Controller\Admin\Questions;
use App\Controller\Admin\Users\Users;
use App\Controller\Admin\Users\Adduser;
use App\Controller\Homepage;
use App\Controller\User\Login;
use App\Controller\Page404;
use Framework\Routing\Route;



return [
    new Route(['GET', 'POST'], '/', Homepage::class),
<<<<<<< HEAD
    new Route(['GET', 'POST'], 'user/profile', Profile::class),
    new Route('GET', '/admin/users/delete/{id}', Users::class),
=======
    new Route(['GET', 'POST'], '/user/profile', Profile::class),
    new Route('GET', '/admin/users/{operation}/{id}', Users::class),
>>>>>>> 32f53a024a02a776c5d55ced47eacea255da785a
    new Route(['GET', 'POST'], '/login', Login::class),
    new Route(['GET', 'POST'], '/admin/users', Users::class),
    new Route(['GET', 'POST'], '/admin/questions', Questions::class),
    new Route(['GET', 'POST'], '/admin/adduser', Adduser::class),

    new Route('GET', '/404', Page404::class),

];
