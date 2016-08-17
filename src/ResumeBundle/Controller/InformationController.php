<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Information;
use ResumeBundle\Form\InformationType;

/**
 * Information controller.
 *
 * @Route("/panel/information")
 */
class InformationController extends Controller
{
    /**
     * Lists all Information entities.
     *
     * @Route("/", name="panel_information_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $information = $em->getRepository('ResumeBundle:Information')->findAll();

        return $this->render('information/index.html.twig', array(
            'information' => $information,
        ));
    }

    /**
     * Creates a new Information entity.
     *
     * @Route("/new", name="panel_information_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $information = new Information();
        $form = $this->createForm('ResumeBundle\Form\InformationType', $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $information->setCreationdate(new \Datetime('now'));
            $information->setLastmodification(new \Datetime('now'));
            $information->setVersion(1);

            $em->persist($information);
            $em->flush();

            return $this->redirectToRoute('panel_information_show', array('id' => $information->getId()));
        }

        return $this->render('information/new.html.twig', array(
            'information' => $information,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Information entity.
     *
     * @Route("/{id}", name="panel_information_show")
     * @Method("GET")
     */
    public function showAction(Information $information)
    {
        $deleteForm = $this->createDeleteForm($information);

        return $this->render('information/show.html.twig', array(
            'information' => $information,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Information entity.
     *
     * @Route("/{id}/edit", name="panel_information_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Information $information)
    {
        $deleteForm = $this->createDeleteForm($information);
        $editForm = $this->createForm('ResumeBundle\Form\InformationType', $information);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information);
            $em->flush();

            return $this->redirectToRoute('panel_information_edit', array('id' => $information->getId()));
        }

        return $this->render('information/edit.html.twig', array(
            'information' => $information,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Information entity.
     *
     * @Route("/{id}", name="panel_information_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Information $information)
    {
        $form = $this->createDeleteForm($information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($information);
            $em->flush();
        }

        return $this->redirectToRoute('panel_information_index');
    }

    /**
     * Creates a form to delete a Information entity.
     *
     * @param Information $information The Information entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Information $information)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_information_delete', array('id' => $information->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
