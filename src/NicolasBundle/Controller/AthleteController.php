<?php

namespace NicolasBundle\Controller;

use NicolasBundle\Entity\Athlete;
use NicolasBundle\Form\AthleteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/athlete")
 */
class AthleteController extends Controller
{
    /**
     * @Route("/", name="athlete")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $athlete = new Athlete();
        $form = $this->createForm(AthleteType::class, $athlete);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $em->persist($athlete);
                $em->flush();

                $athlete = new Athlete();
                $form = $this->createForm(AthleteType::class, $athlete);

                $session = $this->get('session');
                $session->getFlashBag()->add('success', 'Athlète ajouté');
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', 'Erreur lors de l\'ajout de l\'athlète');
            }
        }
        // Get all discipline
        $list_athlete = $em->getRepository('NicolasBundle:Athlete')->findAll();

        return $this->render('NicolasBundle:Athlete:athlete.html.twig', array(
            'list_athlete' => $list_athlete,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit_athlete", requirements={
     *   "id": "\d+"
     * })
     */
    public function editAthleteAction(Request $request, $id)
    {

    }

    /**
     * @Route("/delete/{id}", name="delete_athlete", requirements={
     *   "id": "\d+"
     * })
     */
    public function deleteAthleteAction($id)
    {

    }
}
