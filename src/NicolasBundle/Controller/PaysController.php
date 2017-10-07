<?php

namespace NicolasBundle\Controller;

use NicolasBundle\Entity\Pays;
use NicolasBundle\Form\PaysType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/pays")
 */
class PaysController extends Controller
{
    /**
     * @Route("/", name="pays")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pays = new Pays();
        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $file = $pays->getFlagUrl();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('flags_directory'),
                    $fileName
                );

                $pays->setFlagUrl($fileName);

                $em->persist($pays);
                $em->flush();

                $pays = new Pays();
                $form = $this->createForm(PaysType::class, $pays);

                $session = $this->get('session');
                $session->getFlashBag()->add('success', $this->get('translator')->trans('success.pays.add', array(), 'messages'));
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', $this->get('translator')->trans('error.pays.add', array(), 'messages'));
            }
        }
        // Get all pays
        $list_pays = $em->getRepository('NicolasBundle:Pays')->findAll();

        return $this->render('NicolasBundle:Pays:pays.html.twig', array(
            'list_pays' => $list_pays,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit_pays", requirements={
     *   "id": "\d+"
     * })
     */
    public function editPaysAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('NicolasBundle:Pays')->findOneById($id);

        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $file = $pays->getFlagUrl();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('flags_directory'),
                    $fileName
                );

                $pays->setFlagUrl($fileName);

                $em->persist($pays);
                $em->flush();

                $session = $this->get('session');
                $session->getFlashBag()->add('success', $this->get('translator')->trans('success.pays.modify', array(), 'messages'));

                return $this->redirectToRoute('pays');
            }else{
                $session = $this->get('session');
                $session->getFlashBag()->add('error', $this->get('translator')->trans('error.pays.modify', array(), 'messages'));
            }
        }

        return $this->render('NicolasBundle:Pays:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete_pays", requirements={
     *   "id": "\d+"
     * })
     */
    public function deletePaysAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fs = new Filesystem();

        $pays = $em->getRepository('NicolasBundle:Pays')->findOneById($id);

        $em->remove($pays);
        $em->flush();

        $session = $this->get('session');
        $session->getFlashBag()->add('success', $this->get('translator')->trans('success.pays.delete', array(), 'messages'));

        return $this->redirectToRoute('pays');
    }
}
