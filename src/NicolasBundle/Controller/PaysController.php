<?php

namespace NicolasBundle\Controller;

use NicolasBundle\Entity\Pays;
use NicolasBundle\Form\PaysType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded file
            $file = $pays->getFlagUrl();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where flags are stored
            $file->move(
                $this->getParameter('flags_directory'),
                $fileName
            );

            // Update the 'flag' property to store the file name
            // instead of its contents
            $pays->setFlagUrl($fileName);

            // ... persist the $pays variable or any other work
            $em->persist($pays);
            $em->flush();

            $pays = new Pays();
            $form = $this->createForm(PaysType::class, $pays);

            $this->addFlash('notice', 'Your request has been successfully sent.');
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
    public function editPaysAction($id)
    {
        $em = $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/delete/{id}", name="delete_pays", requirements={
     *   "id": "\d+"
     * })
     */
    public function deletePaysAction($id)
    {
        $em = $this->getDoctrine()->getManager();
    }
}
