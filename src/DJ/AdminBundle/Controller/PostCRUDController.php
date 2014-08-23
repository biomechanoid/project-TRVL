<?php

namespace DJ\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CRUDController;

class PostCRUDController extends CRUDController
{
    public function indexAction($name)
    {
        return $this->render('DJAdminBundle:Default:index.html.twig', array('name' => $name));
    }

    public function newAction() {
        var_dump('new Post ');
        return new Response('some response');
    }
}