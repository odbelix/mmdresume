<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use ResumeBundle\Form\UserType;

class ProfileController extends Controller
{
    protected $menu = "profile";
    /**
     * @Route("/panel/profile/edit")
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        $editForm = $this->createForm('ResumeBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('ResumeBundle:Profile:show.html.twig', array(
              'user' => $user,
              'menu' => $this->getMyMenu()
            ));
        }

        return $this->render('ResumeBundle:Profile:edit.html.twig', array(
          'user' => $user,
          'menu' => $this->getMyMenu(),
          'edit_form' => $editForm->createView()
        ));

    }

    /**
     * @Route("/panel/profile/show")
     */
    public function showAction(Request $request)
    {
        $user = $this->getUser();
        return $this->render('ResumeBundle:Profile:show.html.twig', array(
          'user' => $user,
          'menu' => $this->getMyMenu(),
        ));

    }

    /**
     * @Route("/panel/profile/cancel")
     */
    public function cancelAction(Request $request)
    {
        $user = $this->getUser();
        return $this->render('ResumeBundle:Profile:cancel.html.twig', array(
          'user' => $user,
          'menu' => $this->getMyMenu(),
        ));

    }

    private function getMyMenu(){
      return $this->menu;
    }

}
