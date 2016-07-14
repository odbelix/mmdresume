<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Infotext;
use ResumeBundle\Form\InfotextType;

/**
 * Infotext controller.
 *
 * @Route("/panel/infotext")
 */
class InfotextController extends Controller
{
    /**
     * Lists all Infotext entities.
     *
     * @Route("/", name="panel_infotext_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $infotexts = $em->getRepository('ResumeBundle:Infotext')->findAll();

        return $this->render('infotext/index.html.twig', array(
            'infotexts' => $infotexts,
        ));
    }

    /**
     * Creates a new Infotext entity.
     *
     * @Route("/new", name="panel_infotext_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $infotext = new Infotext();
        $form = $this->createForm('ResumeBundle\Form\InfotextType', $infotext);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($infotext);
            $em->flush();

            return $this->redirectToRoute('panel_infotext_show', array('id' => $infotext->getId()));
        }

        return $this->render('infotext/new.html.twig', array(
            'infotext' => $infotext,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Infotext entity.
     *
     * @Route("/{id}", name="panel_infotext_show")
     * @Method("GET")
     */
    public function showAction(Infotext $infotext)
    {
        $deleteForm = $this->createDeleteForm($infotext);

        return $this->render('infotext/show.html.twig', array(
            'infotext' => $infotext,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Infotext entity.
     *
     * @Route("/{id}/edit", name="panel_infotext_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Infotext $infotext)
    {
        $deleteForm = $this->createDeleteForm($infotext);
        $editForm = $this->createForm('ResumeBundle\Form\InfotextType', $infotext);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($infotext);
            $em->flush();

            return $this->redirectToRoute('panel_infotext_edit', array('id' => $infotext->getId()));
        }

        return $this->render('infotext/edit.html.twig', array(
            'infotext' => $infotext,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Infotext entity.
     *
     * @Route("/{id}", name="panel_infotext_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Infotext $infotext)
    {
        $form = $this->createDeleteForm($infotext);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($infotext);
            $em->flush();
        }

        return $this->redirectToRoute('panel_infotext_index');
    }

    /**
     * Creates a form to delete a Infotext entity.
     *
     * @param Infotext $infotext The Infotext entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Infotext $infotext)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_infotext_delete', array('id' => $infotext->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
