<?php

namespace NicolasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/discipline")
 */
class DisciplineController extends Controller
{
    /**
     * @Route("/", name="discipline")
     */
    public function indexAction()
    {
        return $this->render('NicolasBundle:Discipline:discipline.html.twig');
    }
}
