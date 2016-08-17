<?php

namespace ResumeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\User;
use ResumeBundle\Entity\Information;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
     * @Route("/panel/postulant/inicio/{type}")
     */
    public function firstTimeAction($type)
    {

      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();

      if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ||
        $this->get('security.authorization_checker')->isGranted('ROLE_ASSISTANT') == true) {
          //User already setting
          return $this->redirectToRoute('resume_profile_edit');
      }
      $userdb = $em->getRepository('ResumeBundle:User')->findOneByUsername($user->getUsername());
      $usertype = $em->getRepository('ResumeBundle:Type')->findAll();



      $teachername = "";
      $assistantmidname = "";
      $assistanttopname = "";
      $assistant = "";
      $professional = "";

      $teachernameid = 0;
      $assistantmidnameid = 0;
      $assistanttopnameid = 0;
      $assistantid = 0;
      $professionalid = 0;


      foreach($usertype as $ut) {
        if ( strpos($ut->getName(),"ocentes") !== false ){
            $teachername = $ut->getName();
            $teachernameid = $ut->getId();
        }
        if ( strpos($ut->getName(),"uperior") !== false ){
            $assistanttopname = $ut->getName();
            $assistanttopnameid = $ut->getId();
        }
        if ( strpos($ut->getName(),"edio") !== false ){
            $assistantmidname = $ut->getName();
            $assistantmidnameid = $ut->getId();
        }
        if ( strpos($ut->getName(),"media") !== false ){
            $assistant = $ut->getName();
            $assistantid = $ut->getId();
        }
        if ( strpos($ut->getName(),"rofesional") !== false ){
            $professional = $ut->getName();
            $professionalid = $ut->getId();
        }
      }

      //$user->hasRole('ROLE_ADMIN')
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
      $userManipulator = $this->get('fos_user.util.user_manipulator');
      $username = $user;

      $em = $this->getDoctrine()->getManager();

      if($type == 1) {
        $userManipulator->addRole($username,"ROLE_TEACHER");
        $userdb->setUsertype($teachername);
        $userdb->setUsertypeid($teachernameid);
      }
      else {
        # code...
        $userManipulator->addRole($username,"ROLE_ASSISTANT");
        if( $type == 2 ) {
            $userdb->setUsertype($assistanttopname);
            $userdb->setUsertypeid($assistanttopnameid);
        }
        if( $type == 3 ) {
            $userdb->setUsertype($assistantmidname);
            $userdb->setUsertypeid($assistantmidnameid);
        }
        if( $type == 4 ) {
            $userdb->setUsertype($assistant);
            $userdb->setUsertypeid($assistantid);
        }
        if( $type == 5 ) {
            //$userdb->setUsertype(￼$professional);
            //$userdb->setUsertypeid(￼$professionalid);
            $userdb->setUsertype($professional);
            $userdb->setUsertypeid($professionalid);
        }

      }

      $this->reloadUserPermissions();
      $em->persist($userdb);
      $em->flush();

      return $this->redirectToRoute('resume_profile_edit');
    }


    /**
     * @Route("/panel")
     */
    public function panelAction()
    {
      $user = $this->getUser();
      //$user->hasRole('ROLE_ADMIN')
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }

      if ( $this->get('security.authorization_checker')->isGranted('ROLE_MONITOR') == true ){
          return $this->render('ResumeBundle:Default:panel-backend.html.twig');
      }
      if ( $this->get('security.authorization_checker')->isGranted('ROLE_MANAGER') == true ){
          return $this->render('ResumeBundle:Default:panel-backend.html.twig');
      }
      if ( $this->get('security.authorization_checker')->isGranted('ROLE_DEVELOPER') == true ){
          return $this->render('ResumeBundle:Default:panel-backend.html.twig');
      }
      if ( $this->get('security.authorization_checker')->isGranted('ROLE_DIRECTOR') == true ){
          return $this->render('ResumeBundle:Default:panel-backend.html.twig');
      }
      return $this->redirectToRoute('resume_default_panelpostulant');

    }

    /**
     * @Route("/panel/postulant")
     */
    public function panelPostulantAction()
    {

      $em = $this->getDoctrine()->getManager();
      $message = $em->getRepository('ResumeBundle:Information')->findOneByShortname("welcome_text");

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
      return $this->render('ResumeBundle:Default:panel-postulant.html.twig', array(
        'user' => $user,
        'message' => $message,
        'menu' => ''
      ));
    }

    /**
     * @Route("/panel/asistant")
     */
    public function asistantAction()
    {

      $user = $this->getUser();
      if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
      }
        return $this->render('ResumeBundle:Default:panel-backend.html.twig', array(
              'user' => $user));
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
    protected function reloadUserPermissions()
    {
      $token = new UsernamePasswordToken(
        $this->getUser(),
        null,
        'main',
        $this->getUser()->getRoles()
    );

       $this->get('security.token_storage')->setToken($token);
    }

}
