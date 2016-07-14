<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Workplace;
use ResumeBundle\Form\WorkplaceType;
use ResumeBundle\Controller\InfotextController;

/**
 * Workplace controller.
 *
 * @Route("/panel/workplace")
 */
class WorkplaceController extends Controller
{
    protected $menu = "workplace";
    /**
     * Lists all Workplace entities.
     *
     * @Route("/", name="panel_workplace_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $workplaces = $em->getRepository('ResumeBundle:Workplace')->findAll();

        return $this->render('workplace/index.html.twig', array(
            'workplaces' => $workplaces,
            'menu' => $this->getMyMenu(),
        ));
    }

    /**
     * Creates a new Workplace entity.
     *
     * @Route("/new", name="panel_workplace_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $workplace = new Workplace();
        $form = $this->createForm('ResumeBundle\Form\WorkplaceType', $workplace);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_workplace');



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workplace);
            $em->flush();

            return $this->redirectToRoute('panel_workplace_show', array('id' => $workplace->getId()));
        }

        return $this->render('workplace/new.html.twig', array(
            'workplace' => $workplace,
            'infotext' => $infotext->getText(),
            'menu' => $this->getMyMenu(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Workplace entity.
     *
     * @Route("/{id}", name="panel_workplace_show")
     * @Method("GET")
     */
    public function showAction(Workplace $workplace)
    {
        $deleteForm = $this->createDeleteForm($workplace);

        return $this->render('workplace/show.html.twig', array(
            'workplace' => $workplace,
            'menu' => $this->getMyMenu(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Workplace entity.
     *
     * @Route("/{id}/edit", name="panel_workplace_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Workplace $workplace)
    {
        $deleteForm = $this->createDeleteForm($workplace);
        $editForm = $this->createForm('ResumeBundle\Form\WorkplaceType', $workplace);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workplace);
            $em->flush();

            return $this->redirectToRoute('panel_workplace_edit', array('id' => $workplace->getId()));
        }

        return $this->render('workplace/edit.html.twig', array(
            'workplace' => $workplace,
            'menu' => $this->getMyMenu(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Workplace entity.
     *
     * @Route("/{id}", name="panel_workplace_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Workplace $workplace)
    {
        $form = $this->createDeleteForm($workplace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($workplace);
            $em->flush();
        }

        return $this->redirectToRoute('panel_workplace_index');
    }

    /**
     * Creates a form to delete a Workplace entity.
     *
     * @param Workplace $workplace The Workplace entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Workplace $workplace)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_workplace_delete', array('id' => $workplace->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getMyMenu(){
      return $this->menu;
    }

}
