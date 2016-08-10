<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Usertype;
use ResumeBundle\Form\UsertypeType;

/**
 * Usertype controller.
 *
 * @Route("/panel/usertype")
 */
class UsertypeController extends Controller
{
    /**
     * Lists all Usertype entities.
     *
     * @Route("/", name="panel_usertype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usertypes = $em->getRepository('ResumeBundle:Usertype')->findAll();

        return $this->render('usertype/index.html.twig', array(
            'usertypes' => $usertypes,
        ));
    }

    /**
     * Creates a new Usertype entity.
     *
     * @Route("/new", name="panel_usertype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usertype = new Usertype();
        $form = $this->createForm('ResumeBundle\Form\UsertypeType', $usertype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usertype);
            $em->flush();

            return $this->redirectToRoute('panel_usertype_show', array('id' => $usertype->getId()));
        }

        return $this->render('usertype/new.html.twig', array(
            'usertype' => $usertype,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usertype entity.
     *
     * @Route("/{id}", name="panel_usertype_show")
     * @Method("GET")
     */
    public function showAction(Usertype $usertype)
    {
        $deleteForm = $this->createDeleteForm($usertype);

        return $this->render('usertype/show.html.twig', array(
            'usertype' => $usertype,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usertype entity.
     *
     * @Route("/{id}/edit", name="panel_usertype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usertype $usertype)
    {
        $deleteForm = $this->createDeleteForm($usertype);
        $editForm = $this->createForm('ResumeBundle\Form\UsertypeType', $usertype);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usertype);
            $em->flush();

            return $this->redirectToRoute('panel_usertype_edit', array('id' => $usertype->getId()));
        }

        return $this->render('usertype/edit.html.twig', array(
            'usertype' => $usertype,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usertype entity.
     *
     * @Route("/{id}", name="panel_usertype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usertype $usertype)
    {
        $form = $this->createDeleteForm($usertype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usertype);
            $em->flush();
        }

        return $this->redirectToRoute('panel_usertype_index');
    }

    /**
     * Creates a form to delete a Usertype entity.
     *
     * @param Usertype $usertype The Usertype entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usertype $usertype)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_usertype_delete', array('id' => $usertype->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
