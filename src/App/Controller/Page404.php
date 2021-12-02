<?php

namespace App\Controller;


use Framework\Controller\AbstractController;


class Page404 extends AbstractController{
    public function __invoke():string
    {
        return $this->render('404.html.twig',[]);
    }
}
