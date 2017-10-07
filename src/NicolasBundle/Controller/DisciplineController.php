<?php

namespace NicolasBundle\Controller;

use NicolasBundle\Entity\Discipline;
use NicolasBundle\Form\DisciplineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/discipline")
 */
class DisciplineController extends Controller
{
    /**
     * @Route("/", name="discipline")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $em->persist($discipline);
                $em->flush();

                $discipline = new Discipline();
                $form = $this->createForm(DisciplineType::class, $discipline);

                $session = $this->get('session');
                $session->getFlashBag()->add('success', $this->get('translator')->trans('success.discipline.add', array(), 'messages'));
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', $this->get('translator')->trans('error.discipline.add', array(), 'messages'));
            }
        }
        // Get all discipline
        $list_discipline = $em->getRepository('NicolasBundle:Discipline')->findAll();

        return $this->render('NicolasBundle:Discipline:discipline.html.twig', array(
            'list_discipline' => $list_discipline,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit_discipline", requirements={
     *   "id": "\d+"
     * })
     */
    public function editDisciplineAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $discipline = $em->getRepository('NicolasBundle:Discipline')->findOneById($id);

        $form = $this->createForm(DisciplineType::class, $discipline);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $em->persist($discipline);
                $em->flush();

                $session = $this->get('session');
                $session->getFlashBag()->add('success', $this->get('translator')->trans('success.discipline.modify', array(), 'messages'));

                return $this->redirectToRoute('discipline');
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', $this->get('translator')->trans('error.discipline.modify', array(), 'messages'));
            }
        }

        return $this->render('NicolasBundle:Discipline:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete_discipline", requirements={
     *   "id": "\d+"
     * })
     */
    public function deleteDisciplineAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $discipline = $em->getRepository('NicolasBundle:Discipline')->findOneById($id);

        $em->remove($discipline);
        $em->flush();

        $session = $this->get('session');
        $session->getFlashBag()->add('success', $this->get('translator')->trans('success.discipline.delete', array(), 'messages'));

        return $this->redirectToRoute('discipline');
    }
}
