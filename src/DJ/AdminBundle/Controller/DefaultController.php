<?php

namespace DJ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DJAdminBundle:Default:index.html.twig', array());
    }

}
