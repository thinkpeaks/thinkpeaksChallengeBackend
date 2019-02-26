<?php

namespace TPChallengeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TPChallengeBundle:Default:index.html.twig');
    }
}
