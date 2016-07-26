<?php
namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use ResumeBundle\Entity\Infotext;
use ResumeBundle\Entity\User;

/**
 * Assistant controller.
 *
 * @Route("/panel/postulant")
 */
class PostulantController extends Controller
{

  /**
   * @Route("/teachers",name="panel_postulant_teachers")
   * @Method({"GET","POST"})
   */
  public function indexTeacherAction(Request $request)
  {
    //Validation
    $user = $this->getUser();
    if (!is_object($user)) {
        return $this->render('ResumeBundle:Default:index.html.twig');
    }

    $message = "";

    $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM ResumeBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_TEACHER"%');

    $teachers = $query->getResult();

    return $this->render('postulant/teachers.html.twig',array(
        'teachers' => $teachers,
        'message' => $message,
    ));
  }

  /**
   * @Route("/teacher/profile/{teacherid}",name="panel_postulant_teacher_profile")
   * @Method({"GET"})
   */
  public function showTeacherAction($teacherid)
  {
    //Validation
    $user = $this->getUser();
    if (!is_object($user)) {
        return $this->render('ResumeBundle:Default:index.html.twig');
    }

    $em = $this->getDoctrine()->getEntityManager();

    $message = "";

    $file = null;
    $history = null;
    $titles = null;


    $teacher = $em->getRepository('ResumeBundle:User')->findOneById($teacherid);
    $file = $em->getRepository('ResumeBundle:TeacherFile')->findOneByTeacher($teacher->getUsername());
    $history = $em->getRepository('ResumeBundle:History')->findBy(
    array('userid' => $teacherid), array('startdate' => 'DESC'));

    $titles = $em->getRepository('ResumeBundle:Title')->findBy(
    array('userid' => $teacherid), array('obtaining' => 'DESC'));

    return $this->render('postulant/teacher-profile.html.twig',array(
        'teacher' => $teacher,
        'file' => $file,
        'titles' => $titles,
        'experiences' => $history
    ));
  }


  /**
   * @Route("/asistant/profile/{assistantid}",name="panel_postulant_assistant_profile")
   * @Method({"GET"})
   */
  public function showAssistantAction($assistantid)
  {
    //Validation
    $user = $this->getUser();
    if (!is_object($user)) {
        return $this->render('ResumeBundle:Default:index.html.twig');
    }

    $em = $this->getDoctrine()->getEntityManager();

    $message = "";

    $history = null;
    $titles = null;


    $assistant = $em->getRepository('ResumeBundle:User')->findOneById($assistantid);
    $history = $em->getRepository('ResumeBundle:History')->findBy(
    array('userid' => $assistantid), array('startdate' => 'DESC'));

    $titles = $em->getRepository('ResumeBundle:Title')->findBy(
    array('userid' => $assistantid), array('obtaining' => 'DESC'));

    return $this->render('postulant/assistant-profile.html.twig',array(
        'assistant' => $assistant,
        'titles' => $titles,
        'experiences' => $history
    ));
  }



  /**
   * @Route("/assistants",name="panel_postulant_assistants")
   * @Method({"GET","POST"})
   */
  public function indexAssistantAction(Request $request)
  {
    //Validation
    $user = $this->getUser();
    if (!is_object($user)) {
        return $this->render('ResumeBundle:Default:index.html.twig');
    }

    $message = "";

    $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM ResumeBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_ASSISTANT"%');

    $assistants = $query->getResult();

    return $this->render('postulant/assistants.html.twig',array(
        'assistants' => $assistants,
        'message' => $message,
    ));
  }


  /**
   * Finds and displays a User entity (Monitor)
   *
   * @Route("/{id}", name="panel_assistant_show")
   * @Method("GET")
   */
  public function showAction(User $user)
  {
      return $this->render('assistant/show.html.twig', array(
          'assistant' => $user
      ));
  }

  /**
   * Creates a new Assistant entity.
   *
   * @Route("/register", name="panel_assistant_register")
   * @Method("POST")
   */
  public function registerAction(Request $request)
  {

      if ($request->isMethod('POST')) {
        $userManipulator = $this->get('fos_user.util.user_manipulator');

        $password = $request->request->get('form')['password'];
        $username = $request->request->get('form')['username'];
        $email = $request->request->get('form')['email'];

        $useremail = $this->get('fos_user.user_manager')->findUserByEmail($email);
        if (!$useremail) {

        }

        $isActive = true;
        $isSuperAdmin = false;
        $userManipulator->create($adminUsername, $adminPassword, $adminEmail, $isActive, $isSuperAdmin);
        $userManipulator->addRole($adminUsername,"ROLE_MONITOR");

        return $this->redirectToRoute('panel_assistant_index');

      }
      return $this->render('ResumeBundle:Default:panel-backend.html.twig');

  }

  private function jsonResponse($data)
  {
    $response = new Response();
    $response->setContent(json_encode(array(
      'data' => var_dump($data),
    )));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  private function validationUser($username,$email)
  {
      $message = array();
      $useremail = $this->get('fos_user.user_manager')->findUserByEmail($email);
      if ($useremail) {
          $message["useremail"] = "El correo ya esta siendo utilizado";
      }
      $user = $this->get('fos_user.user_manager')->findUserByUsername($username);
      if ($user) {
          $message["username"] = "El nombre de usuario ya esta siendo utilizado";
      }
      return $message;
  }

  private function sendMonitorFirstEmail($username,$email,$password)
  {
      $message = \Swift_Message::newInstance()
        ->setSubject('Registro DAEM-TALCA-CV')
        ->setFrom('send@example.com')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'assistant/registration.html.twig',
                array('username' => $username,'password' => $password)
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;
    $this->get('mailer')->send($message);

  }



}
