<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Profession;
use ResumeBundle\Form\ProfessionType;
use ResumeBundle\Controller\InfotextController;

/**
 * Profession controller.
 *
 * @Route("/panel/profession")
 */
class ProfessionController extends Controller
{
    /**
     * Lists all Profession entities.
     *
     * @Route("/", name="panel_profession_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $professions = $em->getRepository('ResumeBundle:Profession')->findAll();

        return $this->render('profession/index.html.twig', array(
            'professions' => $professions,
        ));
    }

    /**
     * Creates a new Profession entity.
     *
     * @Route("/new", name="panel_profession_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $profession = new Profession();
        $form = $this->createForm('ResumeBundle\Form\ProfessionType', $profession);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_profession');



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profession);
            $em->flush();

            //return $this->redirectToRoute('panel_profession_show', array('id' => $profession->getId()));
            return $this->redirectToRoute('panel_profession_index');
        }

        return $this->render('profession/new.html.twig', array(
            'profession' => $profession,
            'infotext' => $infotext->getText(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Profession entity.
     *
     * @Route("/{id}", name="panel_profession_show")
     * @Method("GET")
     */
    public function showAction(Profession $profession)
    {
        $deleteForm = $this->createDeleteForm($profession);

        return $this->render('profession/show.html.twig', array(
            'profession' => $profession,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Profession entity.
     *
     * @Route("/{id}/edit", name="panel_profession_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Profession $profession)
    {
        $deleteForm = $this->createDeleteForm($profession);
        $editForm = $this->createForm('ResumeBundle\Form\ProfessionType', $profession);
        $editForm->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_profession');



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profession);
            $em->flush();

            return $this->redirectToRoute('panel_profession_edit', array('id' => $profession->getId()));
        }

        return $this->render('profession/edit.html.twig', array(
            'profession' => $profession,
            'infotext' => $infotext->getText(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Profession entity.
     *
     * @Route("/{id}", name="panel_profession_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Profession $profession)
    {
        $form = $this->createDeleteForm($profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profession);
            $em->flush();
        }

        return $this->redirectToRoute('panel_profession_index');
    }

    /**
     * Creates a form to delete a Profession entity.
     *
     * @param Profession $profession The Profession entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profession $profession)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_profession_delete', array('id' => $profession->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
