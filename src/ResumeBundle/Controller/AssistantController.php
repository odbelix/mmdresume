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
 * @Route("/panel/assistant")
 */
class AssistantController extends Controller
{

  /**
   * @Route("/",name="panel_assistant_index")
   * @Method({"GET","POST"})
   */
  public function indexAction(Request $request)
  {
    //Validation
    $user = $this->getUser();
    if (!is_object($user)) {
        return $this->render('ResumeBundle:Default:index.html.twig');
    }

    $errmessage = array();
    $success = null;

    //FORM FOR NEW assistant
    $data = array();
    $form = $this->createFormBuilder($data)
       ->setAction($this->generateUrl('panel_assistant_index'))
       ->setMethod('POST')
       ->add('username', TextType::class,array('label' => 'Nombre de Usuario'))
       ->add('email', TextType::class,array('label' => 'Correo Electrónico'))
       ->add('password', TextType::class,array('label' => 'Contraseña'))
       ->getForm();

    if ($request->isMethod('POST')) {
      //GETTING INFORMATION FROM POST REQUEST FORM
      //$this->jsonResponse($request->request->all());
      $userManipulator = $this->get('fos_user.util.user_manipulator');

      $password = $request->request->get('form')['password'];
      $username = $request->request->get('form')['username'];
      $email = $request->request->get('form')['email'];

      $errmessage = $this->validationUser($username,$email);

      if ( !array_key_exists("username",$errmessage) && !array_key_exists("useremail",$errmessage) )
      {
         //CREATE NEW MONITOR USER
         $isActive = true;
         $isSuperAdmin = false;
         $userManipulator->create($username, $password, $email, $isActive, $isSuperAdmin);
         $userManipulator->addRole($username,"ROLE_MONITOR");

         //SEND email
         $this->sendMonitorFirstEmail($username,$email,$password);

         $success = "El usuario fue creado con Exito. Un correo fue enviado con la información de Acceso";
      }

    }

    $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM ResumeBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_MONITOR"%');

    $users = $query->getResult();

    return $this->render('assistant/index.html.twig',array(
        'assistants' => $users,
        'message' => $errmessage,
        'success' => $success,
        'new_form' => $form->createView(),
        'count' => count($users),
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
