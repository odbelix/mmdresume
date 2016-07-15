<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\TechnicianMid;
use ResumeBundle\Form\TechnicianMidType;
use ResumeBundle\Controller\InfotextController;

/**
 * TechnicianMid controller.
 *
 * @Route("/panel/technicianmid")
 */
class TechnicianMidController extends Controller
{
    /**
     * Lists all TechnicianMid entities.
     *
     * @Route("/", name="panel_technicianmid_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $technicianMids = $em->getRepository('ResumeBundle:TechnicianMid')->findAll();

        return $this->render('technicianmid/index.html.twig', array(
            'technicianMids' => $technicianMids,
        ));
    }

    /**
     * Creates a new TechnicianMid entity.
     *
     * @Route("/new", name="panel_technicianmid_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $technicianMid = new TechnicianMid();
        $form = $this->createForm('ResumeBundle\Form\TechnicianMidType', $technicianMid);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_technicianmid');



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technicianMid);
            $em->flush();

            return $this->redirectToRoute('panel_technicianmid_index');
        }

        return $this->render('technicianmid/new.html.twig', array(
            'technicianmid' => $technicianMid,
            'infotext' => $infotext->getText(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TechnicianMid entity.
     *
     * @Route("/{id}", name="panel_technicianmid_show")
     * @Method("GET")
     */
    public function showAction(TechnicianMid $technicianMid)
    {
        $deleteForm = $this->createDeleteForm($technicianMid);

        return $this->render('technicianmid/show.html.twig', array(
            'technicianmid' => $technicianMid,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TechnicianMid entity.
     *
     * @Route("/{id}/edit", name="panel_technicianmid_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TechnicianMid $technicianMid)
    {
        $deleteForm = $this->createDeleteForm($technicianMid);
        $editForm = $this->createForm('ResumeBundle\Form\TechnicianMidType', $technicianMid);
        $editForm->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_technicianmid');



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technicianMid);
            $em->flush();

            return $this->redirectToRoute('panel_technicianmid_edit', array('id' => $technicianMid->getId()));
        }

        return $this->render('technicianmid/edit.html.twig', array(
            'technician' => $technicianMid,
            'infotext' => $infotext->getText(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TechnicianMid entity.
     *
     * @Route("/{id}", name="panel_technicianmid_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TechnicianMid $technicianMid)
    {
        $form = $this->createDeleteForm($technicianMid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($technicianMid);
            $em->flush();
        }

        return $this->redirectToRoute('panel_technicianmid_index');
    }

    /**
     * Creates a form to delete a TechnicianMid entity.
     *
     * @param TechnicianMid $technicianMid The TechnicianMid entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TechnicianMid $technicianMid)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_technicianmid_delete', array('id' => $technicianMid->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
