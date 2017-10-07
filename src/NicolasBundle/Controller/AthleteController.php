<?php

namespace NicolasBundle\Controller;

use NicolasBundle\Entity\Athlete;
use NicolasBundle\Form\AthleteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
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
                $file = $athlete->getPicture();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('profil_directory'),
                    $fileName
                );

                $athlete->setPicture($fileName);

                $em->persist($athlete);
                $em->flush();

                $athlete = new Athlete();
                $form = $this->createForm(AthleteType::class, $athlete);

                $session = $this->get('session');
                $session->getFlashBag()->add('success', $this->get('translator')->trans('success.athlete.add', array(), 'messages'));
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', $this->get('translator')->trans('error.athlete.add', array(), 'messages'));
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
        $em = $this->getDoctrine()->getManager();

        $athlete = $em->getRepository('NicolasBundle:Athlete')->findOneById($id);

        $form = $this->createForm(AthleteType::class, $athlete);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $file = $athlete->getPicture();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('profil_directory'),
                    $fileName
                );

                $athlete->setPicture($fileName);

                $em->persist($athlete);
                $em->flush();

                $session = $this->get('session');
                $session->getFlashBag()->add('success', $this->get('translator')->trans('success.athlete.modify', array(), 'messages'));

                return $this->redirectToRoute('athlete');
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', $this->get('translator')->trans('error.athlete.modify', array(), 'messages'));
            }
        }

        return $this->render('NicolasBundle:Athlete:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete_athlete", requirements={
     *   "id": "\d+"
     * })
     */
    public function deleteAthleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fs = new Filesystem();

        $athlete = $em->getRepository('NicolasBundle:Athlete')->findOneById($id);

        $em->remove($athlete);
        $em->flush();

        $session = $this->get('session');
        $session->getFlashBag()->add('success', $this->get('translator')->trans('success.athlete.delete', array(), 'messages'));

        return $this->redirectToRoute('athlete');
    }
}
