<?php

namespace ResumeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormFactory;

use ResumeBundle\Entity\Workplace;
use ResumeBundle\Entity\TeacherFile;
use ResumeBundle\Entity\User;
use ResumeBundle\Entity\Basic;
use ResumeBundle\Entity\Speciality;
use ResumeBundle\Entity\Title;
use ResumeBundle\Entity\History;
use ResumeBundle\Entity\Profession;
use ResumeBundle\Entity\TechnicianTop;
use ResumeBundle\Entity\TechnicianMid;
use Doctrine\ORM\EntityRepository;

/**
 * Resume controller.
 *
 * @Route("/panel/postulant/resume")
 *
 */
class ResumeController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        $em = $this->getDoctrine()->getManager();
        $workplaces = $em->getRepository('ResumeBundle:Workplace')->findAll();

        $listtitle = $this->getListOfTitleAccordingTypeUser($user->getUsertypeid());

        $titles = $em->getRepository('ResumeBundle:Title')->findBy(
        array('userid' => $user->getId()), array('obtaining' => 'DESC'));

        //$titles = null;

        $experiences = $em->getRepository('ResumeBundle:History')->findBy(
        array('userid' => $user->getId()), array('startdate' => 'DESC'));

        $message = null;
        $success = null;
        if ($request->isMethod('POST')) {
            $message = $request->request->get('message');
            $success = $request->request->get('success');
        }
        //
        $formprof = $this->createFormProfForAssistantType($user->getUsertypeid());
        $formexp = $this->createFormExpForAssistantType($user->getUsertypeid(),$titles,$workplaces);

        return $this->render('resume/myresume.html.twig', array(
            'user' => $user,
            'message' => $message,
            'success' => $success,
            'titles' => $titles,
            'exps' => $experiences,
            'new_form_prof' => $formprof->createView(),
            'new_form_exp' => $formexp->createView(),
            'listtitle' => $listtitle,
          ));

    }
    /**
     * @Route("/author/cat/{value}")
     * @Method({"GET"})
     */
    public function catSetAction($value){
      $user = $this->getUser();
      $this->validationAccessForUser($user);

      $em = $this->getDoctrine()->getManager();
      $file = $em->getRepository('ResumeBundle:TeacherFile')->findOneByTeacher($this->getUser()->getUsername());
      if($file){
        if ($value == "true"){
          $file->setCatholic(1);
        }
        if ($value == "false"){
          $file->setCatholic(0);
        }
      }
      else {
        $file = new TeacherFile();
        $file->setTeacher($this->getUser());
        if ($value == "true"){
          $file->setCatholic(1);
        }
        if ($value == "false"){
          $file->setCatholic(0);
        }
        $file->setEvangelical(0);
      }
      $em->persist($file);
      $em->flush();

      $response = new Response(json_encode(array('response' => 'ok')));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }
    /**
     * @Route("/author/eva/{value}")
     * @Method({"GET"})
     */
    public function evaSetAction($value){
      $user = $this->getUser();
      $this->validationAccessForUser($user);

      $em = $this->getDoctrine()->getManager();
      $file = $em->getRepository('ResumeBundle:TeacherFile')->findOneByTeacher($this->getUser()->getUsername());
      if($file){
        if ($value == "true"){
          $file->setEvangelical(1);
        }
        if ($value == "false"){
          $file->setEvangelical(0);
        }
      }
      else {
        $file = new TeacherFile();
        $file->setTeacher($this->getUser());
        if ($value == "true"){
          $file->setEvangelical(1);
        }
        if ($value == "false"){
          $file->setEvangelical(0);
        }
        $file->setCatholic(0);
      }
      $em->persist($file);
      $em->flush();

      $response = new Response(json_encode(array('response' => 'ok')));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/teacher")
     * @Method({"GET","POST"})
     */
    public function teacherAction(Request $request){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        $em = $this->getDoctrine()->getManager();
        $workplaces = $em->getRepository('ResumeBundle:Workplace')->findAll();

        $listtitle = $this->getListOfTitleAccordingTypeUser($user->getUsertypeid());

        $file = $em->getRepository('ResumeBundle:TeacherFile')->findOneByTeacher($this->getUser()->getUsername());


        $titles = $em->getRepository('ResumeBundle:Title')->findBy(
        array('userid' => $user->getId()), array('obtaining' => 'DESC'));

        $experiences = $em->getRepository('ResumeBundle:History')->findBy(
        array('userid' => $user->getId()), array('startdate' => 'DESC'));

        $message = null;
        $success = null;
        if ($request->isMethod('POST')) {
            $message = $request->request->get('message');
            $success = $request->request->get('success');
        }
        //
        $formprofbasic = $this->createFormProfForTeacherType(1);
        $formprofhigh = $this->createFormProfForTeacherType(2);

        $formexp = $this->createFormExpForTeacherType($titles,$workplaces);

        return $this->render('resume/myresume-teacher.html.twig', array(
            'user' => $user,
            'message' => $message,
            'success' => $success,
            'titles' => $titles,
            'file' => $file,
            'exps' => $experiences,
            'new_form_profbasic' => $formprofbasic->createView(),
            'new_form_profhigh' => $formprofhigh->createView(),
            'new_form_exp' => $formexp->createView(),
            'listtitle' => $listtitle,
          ));

    }
    /**
     * @Route("/export/pdf")
     * @Method({"GET","POST"})
     */
    public function exportPDFAction(Request $request){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        $em = $this->getDoctrine()->getManager();

        $titles = $em->getRepository('ResumeBundle:Title')->findBy(
        array('userid' => $user->getId()), array('obtaining' => 'DESC'));

        $experiences = $em->getRepository('ResumeBundle:History')->findBy(
        array('userid' => $user->getId()), array('startdate' => 'DESC'));

        $html = $this->render('resume/myresume_pdf.html.twig', array(
            'user' => $user,
            'titles' => $titles,
            'exps' => $experiences,
        ));
        $this->returnPDFResponseFromHTML($html,$user);
        //return $html;
    }
    /**
     * @Route("/title/delete/{id}/{iduser}")
     * @Method({"GET"})
     */
    public function deteleTitleAction($id,$iduser){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        if ( $user->getId() == $iduser ){
            $em = $this->getDoctrine()->getManager();
            $title = $em->getRepository('ResumeBundle:Title')->findOneBy(
            array('userid' => $user->getId(),'id' => $id));

            $em->remove($title);
            $em->flush();


            //Adding the youngest TITLE to user
            $titles = $em->getRepository('ResumeBundle:Title')->findBy(
            array('userid' => $user->getId()), array('obtaining' => 'DESC'));
            $user->setTitle($titles[0]->getName());


        }
        if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ){
          return $this->redirectToRoute('resume_resume_teacher');
        }
        else {
          return $this->redirectToRoute('resume_resume_index');
        }
    }
    /**
     * @Route("/experience/delete/{id}/{iduser}")
     * @Method({"GET"})
     */
    public function deteleExperienceAction($id,$iduser){
            $user = $this->getUser();
            $this->validationAccessForUser($user);

            if ( $user->getId() == $iduser ){
                $em = $this->getDoctrine()->getManager();
                $exp = $em->getRepository('ResumeBundle:History')->findOneBy(
                array('userid' => $user->getId(),'id' => $id));

                $em->remove($exp);
                $em->flush();
            }

            if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ){
              return $this->redirectToRoute('resume_resume_teacher');
            }
            else {
              return $this->redirectToRoute('resume_resume_index');
            }
        }
   /**
    * @Route("/title/teacher/high/new")
    * @Method({"POST"})
    */
    public function newTitleTeacherHighAction(Request $request){
          $user = $this->getUser();
          $this->validationAccessForUser($user);

          if ($request->isMethod('POST')) {

            $title = $request->request->get('form')['title'];
            $obtaining = $request->request->get('form')['obtaininghigh'];
            $other = $request->request->get('form')['other'];

            $newTitle = new Title();
            $title = $this->getTeacherTitleFromSelection(2,$title);
            if($title){
                $newTitle->setName($title->getName());
                $newTitle->setIdtitle($title->getId());
            }
            else {
                $newTitle->setName($other);
                $newTitle->setIdtitle(0);
            }
            $newTitle->setObtaining($obtaining);
            $newTitle->setUserid($user->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newTitle);
            $em->flush();

            //Adding the youngest TITLE to user
            $titles = $em->getRepository('ResumeBundle:Title')->findBy(
            array('userid' => $user->getId()), array('obtaining' => 'DESC'));
            $user->setTitle($titles[0]->getName());
            $em->persist($user);
            $em->flush();
          }
          return $this->redirectToRoute('resume_resume_teacher');
        }
    /**
     * @Route("/title/teacher/basic/new")
     * @Method({"POST"})
     */
    public function newTitleTeacherBasicAction(Request $request){
      $user = $this->getUser();
      $this->validationAccessForUser($user);

      if ($request->isMethod('POST')) {

        $title = $request->request->get('form')['title'];
        $obtaining = $request->request->get('form')['obtainingbasic'];
        $other = $request->request->get('form')['other'];

        $newTitle = new Title();
        $title = $this->getTeacherTitleFromSelection(1,$title);
        if($title){
            $newTitle->setName($title->getName());
            $newTitle->setIdtitle($title->getId());
        }
        else {
            $newTitle->setName($other);
            $newTitle->setIdtitle(0);
        }
        $newTitle->setObtaining($obtaining);
        $newTitle->setUserid($user->getId());

        $em = $this->getDoctrine()->getManager();
        $em->persist($newTitle);
        $em->flush();

        //Adding the youngest TITLE to user
        $titles = $em->getRepository('ResumeBundle:Title')->findBy(
        array('userid' => $user->getId()), array('obtaining' => 'DESC'));
        $user->setTitle($titles[0]->getName());
        $em->persist($user);
        $em->flush();
      }
      return $this->redirectToRoute('resume_resume_teacher');
    }
    /**
     * @Route("/title/new")
     * @Method({"POST"})
     */
    public function newTitleAction(Request $request){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        if ($request->isMethod('POST')) {


          $title = $request->request->get('form')['title'];
          $obtaining = $request->request->get('form')['obtaining'];
          $other = $request->request->get('form')['other'];

          $newTitle = new Title();

          $title = $this->getTitleFromSelection($user->getUsertypeid(),$title);
          if($title){
              $newTitle->setName($title->getName());
              $newTitle->setIdtitle($title->getId());
              $newTitle->setProfession($title);

          }
          else {
              $newTitle->setName($other);
              $newTitle->setIdtitle(0);
          }

          $newTitle->setObtaining($obtaining);
          $newTitle->setUserid($user->getId());
          $newTitle->setUser($user);

          $em = $this->getDoctrine()->getManager();
          $em->persist($newTitle);
          $em->flush();

          //Adding the youngest TITLE to user
          $titles = $em->getRepository('ResumeBundle:Title')->findBy(
          array('userid' => $user->getId()), array('obtaining' => 'DESC'));
          $user->setTitle($titles[0]->getName());
          $em->persist($user);
          $em->flush();
        }
        return $this->redirectToRoute('resume_resume_index');
    }
    /**
     * @Route("/experience/new")
     * @Method({"POST"})
     */
    public function newExperienceAction(Request $request) {

      $user = $this->getUser();
      $this->validationAccessForUser($user);
      $em = $this->getDoctrine()->getManager();

      if ($request->isMethod('POST')) {
        //GETTING INFORMATION FROM POST REQUEST FORM
        if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ) {
            $titlereq = $request->request->get('form')['title'];
            $data = $em->getRepository('ResumeBundle:Title')->findOneById($titlereq);
            $name = $data->getName();
            $wpreq = $request->request->get('form')['workplace'];
            $wpdata = $em->getRepository('ResumeBundle:Workplace')->findOneById($wpreq);
        }
        else {
            $name = $request->request->get('form')['name'];

        }
        $detail = $request->request->get('form')['detail'];
        $workplace = $request->request->get('form')['workplace'];
        $other = $request->request->get('form')['other'];
        $startdate = $request->request->get('form')['startdate'];
        $enddate = $request->request->get('form')['enddate'];

        //INSERT TITLE
        $newHistory = new History();
        $title = $this->getTitleFromUser($user->getId(),$name);
        $workplace_name = $this->getWorkplaceFromSelection($workplace);

        if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ) {
          $newHistory->setTitle($data);
          $newHistory->setName($name);
          $newHistory->setIdtitle($data->getId());
        }
        else {
          $newHistory->setName($title->getName());
          $newHistory->setIdtitle($title->getId());
        }

        $newHistory->setDetail($detail);
        $newHistory->setWorkplace($workplace_name);
        $newHistory->setOther($other);
        $newHistory->setStartdate(new \Datetime($startdate));
        $newHistory->setEnddate(new \Datetime($enddate));
        $newHistory->setUserid($user->getId());

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHistory);
        $em->flush();
      }

      if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ) {
        return $this->redirectToRoute('resume_resume_teacher');
      }
      else {
        return $this->redirectToRoute('resume_resume_index');
      }

    }

    private function getListOfTitleAccordingTypeUser($idusertype){
        $em = $this->getDoctrine()->getManager();
        if ( $idusertype == 1 ){
          $result = $em->getRepository('ResumeBundle:Speciality')->findAll();
        }
        if ( $idusertype == 2 ){
          $result = $em->getRepository('ResumeBundle:TechnicianTop')->findAll();
        }
        if ( $idusertype == 3 ){
          $result = $em->getRepository('ResumeBundle:TechnicianMid')->findAll();
        }
        if ( $idusertype == 4 ){
          $result = null;
        }
        //PROFESIONAL
        if ( $idusertype == 5 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findAll();
        }
        return $result;
    }
    private function validationAccessForUser($user){
        if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
        }
    }
    protected function getWorkplaceFromSelection($idworkplace){
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('ResumeBundle:Workplace')->findOneById($idworkplace);
        return $result;
    }
    protected function getTitleFromUser($iduser,$idselected){
      $em = $this->getDoctrine()->getManager();
      $title = $em->getRepository('ResumeBundle:Title')->findOneBy(
      array('userid' => $iduser,'id' => $idselected));
      return $title;
    }
    protected function getTeacherTitleFromSelection($typeteacher,$idselected){
      $em = $this->getDoctrine()->getManager();
      if ( $typeteacher == 1 ){
        $result = $em->getRepository('ResumeBundle:Basic')->findOneById($idselected);
      }
      if ( $typeteacher == 2 ){
        $result = $em->getRepository('ResumeBundle:Speciality')->findOneById($idselected);
      }
      return $result;
    }
    protected function getTitleFromSelection($idusertype,$idselected){
        $em = $this->getDoctrine()->getManager();
        if ( $idusertype == 1 ){
          $result = $em->getRepository('ResumeBundle:Speciality')->findOneById($idselected);
        }
        if ( $idusertype == 2 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        if ( $idusertype == 3 ){
          $result = $em->getRepository('ResumeBundle:TechnicianMid')->findOneById($idselected);
        }
        if ( $idusertype == 4 ){

        }
        //PROFESIONAL
        if ( $idusertype == 5 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        return $result;
    }
    protected function createFormProfForAssistantType($idusertype){
      $result = null;
      $classForm = '';

      $em = $this->getDoctrine()->getManager();

      if ( $idusertype == 1 ){
          $classForm = 'ResumeBundle:Speciality';
      }
      if ( $idusertype == 2 ){
          $classForm = 'ResumeBundle:Profession';
      }
      if ( $idusertype == 3 ){
          $classForm = 'ResumeBundle:TechnicianMid';
      }
      if ( $idusertype == 4 ){

      }
      //PROFESIONAL
      if ( $idusertype == 5 ){
        //$result = $em->getRepository('ResumeBundle:Profession')->findAll();
        $classForm = 'ResumeBundle:Profession';
      }
      //FORM
      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl('resume_resume_newtitle'))
         ->setMethod('POST')
         ->add('title', EntityType::class,array('label' => 'Título',
              'required' => false,
              'placeholder' => 'Selecciona una opción',
              'class' => $classForm))
         ->add('obtaining',  DateType::class, array(
             'label' => 'Año de Titulación',
             'widget' => 'single_text',
             'format' => 'dd-MM-yyyy',
             'years' => range(date('Y'), date('Y')-40),
             'attr' => array(
             'class' => 'form-control input-inline datepicker',
             'data-provide' => 'datepicker',
             'data-date-format' => 'dd-mm-yyyy',
             'language' => 'es'
             )
         ))
         ->add('other', TextType::class,array('label' => 'Otro Título Profesional',
            'required' => false))
         ->getForm();

      return $form;
    }
    protected function createFormProfForTeacherType($idtype){
      $result = null;
      $classForm = '';
      $title = '';
      $url = '';
      $year;
      $em = $this->getDoctrine()->getManager();

      if ( $idtype == 1 ){
        $classForm = 'ResumeBundle:Basic';
        $title = 'Título Educación Básica';
        $url = 'resume_resume_newtitleteacherbasic';
        $year = 'obtainingbasic';
      }
      else {
        $classForm = 'ResumeBundle:Speciality';
        $title = 'Título Educación Media';
        $url = 'resume_resume_newtitleteacherhigh';
        $year = 'obtaininghigh';
      }

      //FORM
      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl($url))
         ->setMethod('POST')

         ->add('title', EntityType::class,array('label' => $title,
              'required' => false,
              'placeholder' => 'Selecciona una opción',
              'class' => $classForm))
         ->add($year,  DateType::class, array(
             'label' => 'Año de Titulación',
             'widget' => 'single_text',
             'format' => 'dd-MM-yyyy',
             'years' => range(date('Y'), date('Y')-40),
             'attr' => array(
             'class' => 'form-control input-inline datepicker',
             'data-provide' => 'datepicker',
             'data-date-format' => 'dd-mm-yyyy',
             'language' => 'es'
             )
         ))
         ->add('other', TextType::class,array('label' => 'Otro Título',
            'required' => false))
         ->getForm();

      return $form;
    }
    protected function createFormExpForAssistantType($idusertype,$titles,$workplaces){
      $result = null;
      $classForm = '';
      $classWorkplace = "ResumeBundle:Workplace";

      $em = $this->getDoctrine()->getManager();

      if ( $idusertype == 1 ){
          $classForm = 'ResumeBundle:Speciality';
      }
      if ( $idusertype == 2 ){
          $classForm = 'ResumeBundle:Profession';
      }
      if ( $idusertype == 3 ){
          $classForm = 'ResumeBundle:Profession';
      }
      if ( $idusertype == 4 ){

      }
      //PROFESIONAL
      if ( $idusertype == 5 ){
        //$classForm = 'ResumeBundle:Title';
      }
      //FORM

      $classForm = 'ResumeBundle:Profession';
      
      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl('resume_resume_newexperience'))
         ->setMethod('POST')
         ->add('name', EntityType::class,array('label' => 'Título',
              'placeholder' => 'Selecciona una opción',
              'class' => $classForm,
              'choices' => $titles))
          ->add('detail', TextType::class,array('label' => 'Detalle/Observación',
                 'required' => false))
          ->add('workplace',EntityType::class,array('label' => 'Establecimiento',
               'placeholder' => 'Selecciona una opción',
               'class' => $classWorkplace,
               'choices' => $workplaces,
               'required' => false))
          ->add('other', TextType::class,array('label' => 'Otro Establecimiento',
                'required' => false))
         ->add('startdate',  DateType::class, array(
             'required' => false,
             'label' => 'Fecha de Inicio',
             'widget' => 'single_text',
             'format' => 'dd-MM-yyyy',
             'years' => range(date('Y'), date('Y')-40),
             'attr' => array(
             'class' => 'form-control input-inline datepicker',
             'data-provide' => 'datepicker',
             'data-date-format' => 'dd-mm-yyyy',
             'language' => 'es'
             )
         ))
         ->add('enddate',  DateType::class, array(
             'label' => 'Fecha de Termino',
             'widget' => 'single_text',
             'format' => 'dd-MM-yyyy',
             'years' => range(date('Y'), date('Y')-40),
             'attr' => array(
             'class' => 'form-control input-inline datepicker',
             'data-provide' => 'datepicker',
             'data-date-format' => 'dd-mm-yyyy',
             'language' => 'es'
             )
         ))
         ->getForm();

      return $form;
    }
    protected function createFormExpForTeacherType($titles,$workplaces){
      $history = new History();
      $form = $this->createFormBuilder($history)
        ->setAction($this->generateUrl('resume_resume_newexperience'))
        ->setMethod('POST')
        ->add('title', EntityType::class,array('label' => 'Título ',
             'placeholder' => 'Selecciona una opción',
             'class' => 'ResumeBundle:Title',
             'choices' => $titles))
         ->add('detail', TextareaType::class, array('label' => 'Detalle / Observación',
           'attr' => array('class' => 'tinymce','class' => 'textbox')))
         ->add('workplace',EntityType::class,array('label' => 'Establecimiento',
              'placeholder' => 'Selecciona una opción',
              'class' => 'ResumeBundle:Workplace',
              'choices' => $workplaces,
              'required' => false))
         ->add('other', TextType::class,array('label' => 'Otro Establecimiento',
               'required' => false))
        ->add('startdate',  DateType::class, array(
            'required' => false,
            'label' => 'Fecha de Inicio',
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'years' => range(date('Y'), date('Y')-40),
            'attr' => array(
            'class' => 'form-control input-inline datepicker',
            'data-provide' => 'datepicker',
            'data-date-format' => 'dd-mm-yyyy',
            'language' => 'es'
            )
        ))
        ->add('enddate',  DateType::class, array(
            'label' => 'Fecha de Termino',
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'years' => range(date('Y'), date('Y')-40),
            'attr' => array(
            'class' => 'form-control input-inline datepicker',
            'data-provide' => 'datepicker',
            'data-date-format' => 'dd-mm-yyyy',
            'language' => 'es'
            )
        ))
        ->getForm();
      return $form;
    }
    private function returnPDFResponseFromHTML($html,$user){
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Mobcv - CV Management platform');
        $pdf->SetTitle(('CV'));
        $pdf->SetSubject('Mobcv - CV Management platform');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 10, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();

        //$filename = 'cv_'.$user->getUsername();
        $filename = 'cv_'.$user->getFirstname();

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }


}
