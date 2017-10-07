<?php

namespace NicolasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage_nicolas")
     */
    public function indexAction()
    {
        return $this->render('NicolasBundle:Default:home.html.twig');
    }
}
