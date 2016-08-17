<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Assigment;
use ResumeBundle\Form\AssigmentType;

/**
 * Assigment controller.
 *
 * @Route("/panel/assigment")
 */
class AssigmentController extends Controller
{
    /**
     * Lists all Assigment entities.
     *
     * @Route("/", name="panel_assigment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $assigments = $em->getRepository('ResumeBundle:Assigment')->findAll();

        return $this->render('assigment/index.html.twig', array(
            'assigments' => $assigments,
        ));
    }

    /**
     * Creates a new Assigment entity.
     *
     * @Route("/new", name="panel_assigment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $assigment = new Assigment();
        $form = $this->createForm('ResumeBundle\Form\AssigmentType', $assigment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assigment);
            $em->flush();

            return $this->redirectToRoute('panel_assigment_show', array('id' => $assigment->getId()));
        }

        return $this->render('assigment/new.html.twig', array(
            'assigment' => $assigment,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new Assigment entity.
     *
     * @Route("/save/{jobid}/{userid}", name="panel_assigment_save")
     * @Method({"GET", "POST"})
     */
    public function saveAction($jobid,$userid)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $job = $em->getRepository('ResumeBundle:Job')->findOneById($jobid);
        $user = $em->getRepository('ResumeBundle:User')->findOneById($userid);


        $assigment = new Assigment();
        $assigment->setTeacher($userid);
        $assigment->setDateassigment(new \DateTime('now'));
        $assigment->setVersion(1);
        $assigment->setResponsable($this->getUser());
        $assigment->setUser($user);
        $assigment->setJob($job);

        $em = $this->getDoctrine()->getManager();
        $em->persist($assigment);
        $em->flush();

        return $this->redirectToRoute('panel_assigment_index', array('id' => $assigment->getId()));

    }







    /**
     * Finds and displays a Assigment entity.
     *
     * @Route("/{id}", name="panel_assigment_show")
     * @Method("GET")
     */
    public function showAction(Assigment $assigment)
    {
        $deleteForm = $this->createDeleteForm($assigment);

        return $this->render('assigment/show.html.twig', array(
            'assigment' => $assigment,
            'delete_form' => $deleteForm->createView(),
        ));
    }






    /**
     * Displays a form to edit an existing Assigment entity.
     *
     * @Route("/{id}/edit", name="panel_assigment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Assigment $assigment)
    {
        $deleteForm = $this->createDeleteForm($assigment);
        $editForm = $this->createForm('ResumeBundle\Form\AssigmentType', $assigment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assigment);
            $em->flush();

            return $this->redirectToRoute('panel_assigment_edit', array('id' => $assigment->getId()));
        }

        return $this->render('assigment/edit.html.twig', array(
            'assigment' => $assigment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Assigment entity.
     *
     * @Route("/{id}", name="panel_assigment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Assigment $assigment)
    {
        $form = $this->createDeleteForm($assigment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($assigment);
            $em->flush();
        }

        return $this->redirectToRoute('panel_assigment_index');
    }

    /**
     * Creates a form to delete a Assigment entity.
     *
     * @param Assigment $assigment The Assigment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Assigment $assigment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_assigment_delete', array('id' => $assigment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
