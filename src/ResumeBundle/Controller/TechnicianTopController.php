<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\TechnicianTop;
use ResumeBundle\Form\TechnicianTopType;
use ResumeBundle\Controller\InfotextController;

/**
 * TechnicianTop controller.
 *
 * @Route("/panel/techniciantop")
 */
class TechnicianTopController extends Controller
{
    /**
     * Lists all TechnicianTop entities.
     *
     * @Route("/", name="panel_techniciantop_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $technicianTops = $em->getRepository('ResumeBundle:TechnicianTop')->findAll();

        return $this->render('techniciantop/index.html.twig', array(
            'technicianTops' => $technicianTops,
        ));
    }

    /**
     * Creates a new TechnicianTop entity.
     *
     * @Route("/new", name="panel_techniciantop_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $technicianTop = new TechnicianTop();
        $form = $this->createForm('ResumeBundle\Form\TechnicianTopType', $technicianTop);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_techniciantop');



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technicianTop);
            $em->flush();

            return $this->redirectToRoute('panel_techniciantop_show', array('id' => $technicianTop->getId()));
        }

        return $this->render('techniciantop/new.html.twig', array(
            'technicianTop' => $technicianTop,
            'infotext' => $infotext->getText(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TechnicianTop entity.
     *
     * @Route("/{id}", name="panel_techniciantop_show")
     * @Method("GET")
     */
    public function showAction(TechnicianTop $technicianTop)
    {
        $deleteForm = $this->createDeleteForm($technicianTop);

        return $this->render('techniciantop/show.html.twig', array(
            'techniciantop' => $technicianTop,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TechnicianTop entity.
     *
     * @Route("/{id}/edit", name="panel_techniciantop_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TechnicianTop $technicianTop)
    {
        $deleteForm = $this->createDeleteForm($technicianTop);
        $editForm = $this->createForm('ResumeBundle\Form\TechnicianTopType', $technicianTop);
        $editForm->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_techniciantop');



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technicianTop);
            $em->flush();

            return $this->redirectToRoute('panel_techniciantop_edit', array('id' => $technicianTop->getId()));
        }

        return $this->render('techniciantop/edit.html.twig', array(
            'technicianTop' => $technicianTop,
            'infotext' => $infotext->getText(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TechnicianTop entity.
     *
     * @Route("/{id}", name="panel_techniciantop_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TechnicianTop $technicianTop)
    {
        $form = $this->createDeleteForm($technicianTop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($technicianTop);
            $em->flush();
        }

        return $this->redirectToRoute('panel_techniciantop_index');
    }

    /**
     * Creates a form to delete a TechnicianTop entity.
     *
     * @param TechnicianTop $technicianTop The TechnicianTop entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TechnicianTop $technicianTop)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_techniciantop_delete', array('id' => $technicianTop->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
