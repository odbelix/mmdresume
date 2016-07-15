<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Basic;
use ResumeBundle\Form\BasicType;
use ResumeBundle\Controller\InfotextController;

/**
 * Basic controller.
 *
 * @Route("/panel/basic")
 */
class BasicController extends Controller
{
    /**
     * Lists all Basic entities.
     *
     * @Route("/", name="panel_basic_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $basics = $em->getRepository('ResumeBundle:Basic')->findAll();

        return $this->render('basic/index.html.twig', array(
            'basics' => $basics,
        ));
    }

    /**
     * Creates a new Basic entity.
     *
     * @Route("/new", name="panel_basic_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $basic = new Basic();
        $form = $this->createForm('ResumeBundle\Form\BasicType', $basic);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_basic');


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($basic);
            $em->flush();

            return $this->redirectToRoute('panel_basic_show', array('id' => $basic->getId()));
        }

        return $this->render('basic/new.html.twig', array(
            'basic' => $basic,
            'infotext' => $infotext->getText(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Basic entity.
     *
     * @Route("/{id}", name="panel_basic_show")
     * @Method("GET")
     */
    public function showAction(Basic $basic)
    {
        $deleteForm = $this->createDeleteForm($basic);

        return $this->render('basic/show.html.twig', array(
            'basic' => $basic,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Basic entity.
     *
     * @Route("/{id}/edit", name="panel_basic_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Basic $basic)
    {
        $deleteForm = $this->createDeleteForm($basic);
        $editForm = $this->createForm('ResumeBundle\Form\BasicType', $basic);
        $editForm->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_basic');


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($basic);
            $em->flush();

            return $this->redirectToRoute('panel_basic_edit', array('id' => $basic->getId()));
        }

        return $this->render('basic/edit.html.twig', array(
            'basic' => $basic,
            'infotext' => $infotext->getText(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Basic entity.
     *
     * @Route("/{id}", name="panel_basic_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Basic $basic)
    {
        $form = $this->createDeleteForm($basic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($basic);
            $em->flush();
        }

        return $this->redirectToRoute('panel_basic_index');
    }

    /**
     * Creates a form to delete a Basic entity.
     *
     * @param Basic $basic The Basic entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Basic $basic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_basic_delete', array('id' => $basic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
