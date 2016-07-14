<?php

namespace ResumeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ResumeBundle:Default:index.html.twig');
    }

    /**
     * @Route("/panel")
     */
    public function panelAction()
    {

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
        return $this->render('ResumeBundle:Default:panel-backend.html.twig');
    }


    /**
     * @Route("/panel/monitor")
     */
    public function monitorAction()
    {

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
        return $this->render('ResumeBundle:Monitor:monitor.html.twig', array(
              'user' => $user,
              'menu' => 'monitor'
            ));
    }

    /**
     * @Route("/panel/￼assignments")
     */
    public function assignmentsAction()
    {

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
        return $this->render('ResumeBundle:Assignment:assignments.html.twig', array(
              'user' => $user,
              'menu' => 'assignment'
            ));
    }

    /**
     * @Route("/panel/￼resume")
     */
    public function resumeAction()
    {

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
      return $this->render('ResumeBundle:Resume:resume.html.twig', array(
            'user' => $user,
            'menu' => 'resume'
      ));
    }




    /**
     * @Route("/panelit")
     */
    public function panelitAction()
    {

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
        return $this->render('ResumeBundle:Default:panel-backend.html.twig');
    }


}
