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
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;


use ResumeBundle\Entity\Workplace;
use ResumeBundle\Entity\TeacherFile;
use ResumeBundle\Entity\TeacherDirector;
use ResumeBundle\Entity\User;
use ResumeBundle\Entity\Experience;
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
        array('user' => $user), array('obtaining' => 'DESC'));

        //$titles = null;

        $experiences = $em->getRepository('ResumeBundle:Experience')->findBy(
        array('user' => $user), array('startdate' => 'DESC'));

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
     * @Route("/assistant",name="resume_resume_school")
     * @Method({"GET","POST"})
     */
    public function indexSchoolAssistantAction(Request $request){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        $em = $this->getDoctrine()->getManager();
        $workplaces = $em->getRepository('ResumeBundle:Workplace')->findAll();

        $message = null;
        $success = null;
        if ($request->isMethod('POST')) {
            $message = $request->request->get('message');
            $success = $request->request->get('success');
        }

        $experiences = $em->getRepository('ResumeBundle:Experience')->findBy(
        array('user' => $user), array('startdate' => 'DESC'));

        $formexp = $this->createFormExpForSchoolAssistantType($workplaces);

        return $this->render('resume/myresume-school.html.twig', array(
            'user' => $user,
            'message' => $message,
            'success' => $success,
            'exps' => $experiences,
            'new_form_exp' => $formexp->createView(),
          ));

    }

    /**
     * @Route("/experience/new/school",name="resume_resume_newschoolexp")
     * @Method({"POST"})
     */
    public function newSchoolExperienceAction(Request $request) {

      $user = $this->getUser();
      $this->validationAccessForUser($user);
      $em = $this->getDoctrine()->getManager();

      if ($request->isMethod('POST')) {
        //GETTING INFORMATION FROM POST REQUEST FORM
        $wpreq = $request->request->get('form')['workplace'];
        $wp = $em->getRepository('ResumeBundle:Workplace')->findOneById($wpreq);

        $detail = $request->request->get('form')['detail'];
        $other = $request->request->get('form')['other'];
        $startdate = $request->request->get('form')['startdate'];
        $enddate = $request->request->get('form')['enddate'];

        //INSERT TITLE
        $newExp = new Experience();
        $newExp->setUser($user);
        $newExp->setDetail($detail);
        $newExp->setWorkplace($wp);
        $newExp->setOther($other);
        $newExp->setStartdate(new \Datetime('01-'.$startdate));
        if ( strlen($enddate) != 0 )
          $newExp->setEnddate(new \Datetime('01-'.$enddate));

        $em = $this->getDoctrine()->getManager();
        $em->persist($newExp);
        $em->flush();

        $this->addFlash(
          'success',
          'La información fue guardada con exito'
        );

      }

      return $this->redirectToRoute('resume_resume_school');
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

        $experiences = $em->getRepository('ResumeBundle:Experience')->findBy(
        array('user' => $user), array('startdate' => 'DESC'));

        $heads = $em->getRepository('ResumeBundle:TeacherDirector')->findBy(
        array('user' => $user), array('startdate' => 'DESC'));


        if ($request->isMethod('POST')) {
            $message = $request->request->get('message');
            $success = $request->request->get('success');
        }
        //
        $formprofbasic = $this->createFormProfForTeacherType(1);
        $formprofhigh = $this->createFormProfForTeacherType(2);
        $formheadmaster = $this->createFormHeadmaster();

        $formexp = $this->createFormExpForTeacherType($titles,$workplaces);

        return $this->render('resume/myresume-teacher.html.twig', array(
            'user' => $user,
            'heads' => $heads,
            'titles' => $titles,
            'file' => $file,
            'exps' => $experiences,
            'new_form_headmaster' => $formheadmaster->createView(),
            'new_form_profbasic' => $formprofbasic->createView(),
            'new_form_profhigh' => $formprofhigh->createView(),
            'new_form_exp' => $formexp->createView(),
            'listtitle' => $listtitle,
          ));

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
            array('user' => $user,'id' => $id));

            try {

              $em->remove($title);
              $em->flush();
              $this->addFlash(
                'success',
                'La información fue eliminada con exito'
              );

              //Adding the youngest TITLE to user
              $titles = $em->getRepository('ResumeBundle:Title')->findBy(
              array('userid' => $user->getId()), array('obtaining' => 'DESC'));
              $user->setTitle($titles[0]->getName());


            }
            catch(ForeignKeyConstraintViolationException $e){
              $this->addFlash(
                'error',
                'No se puede eliminar el título/profesión ['.$title->getName().']. Este tiene una Experiencia relacionada '
              );
            }

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

            if ( $user->getUsername() == $iduser ){
                $em = $this->getDoctrine()->getManager();
                $exp = $em->getRepository('ResumeBundle:Experience')->findOneBy(
                array('user' => $user,'id' => $id));

                $em->remove($exp);
                $em->flush();

                $this->addFlash(
                  'success',
                  'La información fue eliminada con exito'
                );
            }

            if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ){
              return $this->redirectToRoute('resume_resume_teacher');
            }
            else {
              if ( $user->getUsertypeid() == 4)
                return $this->redirectToRoute('resume_resume_school');
              else
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
          if (array_key_exists('obtaining',$request->request->get('form'))) {
            $obtaining = $request->request->get('form')['obtaining'];
          }
          else {
              if (array_key_exists('obtainingbasic',$request->request->get('form'))) {
                  $obtaining = $request->request->get('form')['obtainingbasic'];
              }
              else {
                  $obtaining = $request->request->get('form')['obtaininghigh'];
              }
          }
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

          $this->addFlash(
            'success',
            'La información fue guardada con exito'
          );



          //Adding the youngest TITLE to user
          $titles = $em->getRepository('ResumeBundle:Title')->findBy(
          array('userid' => $user->getId()), array('obtaining' => 'DESC'));
          $user->setTitle($titles[0]->getName());
          $em->persist($user);
          $em->flush();
        }
        if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ){
          return $this->redirectToRoute('resume_resume_teacher');
        }
        else {
          if ( $user->getUsertypeid() == 4)
            return $this->redirectToRoute('resume_resume_school');
          else
            return $this->redirectToRoute('resume_resume_index');
        }
    }

    /**
     * @Route("/headmaster/new",name="resume_resume_newheadmaster")
     * @Method({"POST"})
     */
    public function newHeadmasterAction(Request $request){
        $user = $this->getUser();
        $this->validationAccessForUser($user);

        if ($request->isMethod('POST')) {

          $workplace = $request->request->get('form')['workplace'];
          $startdate = $request->request->get('form')['start'];
          $enddate = $request->request->get('form')['end'];
          $other = $request->request->get('form')['other'];

          $newHeadmaster = new TeacherDirector();

          $em = $this->getDoctrine()->getManager();
          $wp = $em->getRepository('ResumeBundle:Workplace')->findOneById($workplace);
          if($wp){
              $newHeadmaster->setWorkplace($wp);
          }
          else {
              $newHeadmaster->setOther($other);
          }
          $newHeadmaster->setUser($user);
          $newHeadmaster->setStartdate(new \Datetime($startdate));
          if ( strlen($enddate) != 0 ){
            $newHeadmaster->setEnddate(new \Datetime($enddate));
          }

          $em = $this->getDoctrine()->getManager();
          $em->persist($newHeadmaster);
          $em->flush();


        }
        return $this->redirectToRoute('resume_resume_teacher');
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
        /*if ( $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') == true ) {
            $titlereq = $request->request->get('form')['title'];
            $title = $em->getRepository('ResumeBundle:Title')->findOneById($titlereq);
            $wpreq = $request->request->get('form')['workplace'];
            $wp = $em->getRepository('ResumeBundle:Workplace')->findOneById($wpreq);
        }*/

        var_dump($request->request->get('form'));
        $titlereq = $request->request->get('form')['title'];
        $title = $em->getRepository('ResumeBundle:Title')->findOneById($titlereq);
        $wpreq = $request->request->get('form')['workplace'];
        $wp = $em->getRepository('ResumeBundle:Workplace')->findOneById($wpreq);
        $detail = $request->request->get('form')['detail'];
        $other = $request->request->get('form')['other'];
        $startdate = $request->request->get('form')['startdate'];
        $enddate = $request->request->get('form')['enddate'];

        //INSERT TITLE
        $newExp = new Experience();

        $newExp->setTitle($title);
        $newExp->setDetail($detail);
        $newExp->setWorkplace($wp);
        $newExp->setOther($other);
        #start Date
        $newExp->setStartdate(new \Datetime('01-'.$startdate));
        if ( strlen($enddate) != 0 )
          $newExp->setEnddate(new \Datetime('01-'.$enddate));

        $newExp->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newExp);
        $em->flush();


        $this->addFlash(
          'success',
          'La información fue guardada con exito'
        );


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
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        if ( $idusertype == 2 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        if ( $idusertype == 3 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        if ( $idusertype == 4 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        //PROFESIONAL
        if ( $idusertype == 5 ){
          $result = $em->getRepository('ResumeBundle:Profession')->findOneById($idselected);
        }
        return $result;
    }

    /**
     * Form for create new Assistant Title
     *
     */
    protected function createFormProfForAssistantType($idusertype){
      $result = null;
      $classForm = '';

      $em = $this->getDoctrine()->getManager();
      $classForm = 'ResumeBundle:Profession';
      $choices = $em->getRepository('ResumeBundle:Profession')->findByUsertype($idusertype);

      //FORM
      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl('resume_resume_newtitle'))
         ->setMethod('POST')
         ->add('title', EntityType::class,array('label' => 'Título',
              'required' => false,
              'placeholder' => 'Selecciona una opción',
              'class' => $classForm,
              'choices' => $choices,))
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



    /**
     * Form for create new Teacher Headmaster details
     *
     */
    protected function createFormHeadmaster(){
      $result = null;
      $classForm = '';
      $title = '';
      $url = '';
      $year;
      $em = $this->getDoctrine()->getManager();
      $classForm = 'ResumeBundle:Workplace';
      //FORM
      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl('resume_resume_newheadmaster'))
         ->setMethod('POST')
         ->add('workplace', EntityType::class,array('label' => 'Establecimiento',
              'required' => false,
              'attr' => array(
               'class' => 'form-control'),
              'placeholder' => 'Selecciona una opción',
              'class' => $classForm))
         ->add('other', TextType::class,array('label' => 'Otro Establecimiento',
              'attr' => array(
                'class' => 'form-control'),
              'required' => false))
            ->add('start',  DateType::class, array(
               'required' => true,
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
           ->add('end',  DateType::class, array(
               'required' => false,
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
    /**
     * Form for create new Teacher Title
     *
     */
    protected function createFormProfForTeacherType($idtype){
      $result = null;
      $classForm = '';
      $title = '';
      $url = '';
      $year;
      $em = $this->getDoctrine()->getManager();

      $classForm = 'ResumeBundle:Profession';
      $em = $this->getDoctrine()->getManager();

      $url = 'resume_resume_newtitle';

      if ( $idtype == 1 ){
        $title = 'Título Educación Básica';
        $year = 'obtainingbasic';
        $repo = $this->getDoctrine()
                 ->getRepository('ResumeBundle:Profession');
        $query = $repo->createQueryBuilder('p')
                  ->where('p.name LIKE :name')
                  ->andwhere('p.usertype = 1')
                  ->setParameter('name', '%ásica%')
                  ->getQuery();
        $choice = $query->getResult();
      }
      else {
        $title = 'Título Educación Media';
        $year = 'obtaininghigh';

        $repo = $this->getDoctrine()
                 ->getRepository('ResumeBundle:Profession');
        $query = $repo->createQueryBuilder('p')
                  ->where('p.name LIKE :name')
                  ->andwhere('p.usertype = 1')
                  ->setParameter('name', '%edia%')
                  ->getQuery();
        $choice = $query->getResult();

      }

      //FORM
      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl($url))
         ->setMethod('POST')

         ->add('title', EntityType::class,array('label' => $title,
              'required' => false,
              'placeholder' => 'Selecciona una opción',
              'class' => $classForm,
              'choices' => $choice))
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

    /**
     * Form for create new School Assistant Experience
     *
     */
    protected function createFormExpForSchoolAssistantType($workplaces){
      $result = null;
      $classForm = '';
      $classWorkplace = "ResumeBundle:Workplace";
      $em = $this->getDoctrine()->getManager();

      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl('resume_resume_newschoolexp'))
         ->setMethod('POST')
         ->add('detail', TextType::class,array('label' => 'Detalle/Observación',
                 'required' => true))
         ->add('workplace',EntityType::class,array('label' => 'Establecimiento',
               'placeholder' => 'Selecciona una opción',
               'class' => $classWorkplace,
               'choices' => $workplaces,
               'required' => false))
          ->add('other', TextType::class,array('label' => 'Otro Establecimiento',
                'required' => false))
          ->add('startdate',  DateType::class, array(
             'required' => true,
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
             'required' => false,
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



    protected function createFormExpForAssistantType($idusertype,$titles,$workplaces){
      $result = null;
      $classForm = '';
      $classWorkplace = "ResumeBundle:Workplace";
      $classForm = 'ResumeBundle:Title';

      $data = array();
      $form = $this->createFormBuilder($data)
         ->setAction($this->generateUrl('resume_resume_newexperience'))
         ->setMethod('POST')
         ->add('title', EntityType::class,array('label' => 'Título',
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
             'required' => true,
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
             'required' => false,
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
      $exp = new Experience();
      $form = $this->createFormBuilder($exp)
        ->setAction($this->generateUrl('resume_resume_newexperience'))
        ->setMethod('POST')
        ->add('title', EntityType::class,array('label' => 'Título ',
             'placeholder' => 'Selecciona una opción',
             'class' => 'ResumeBundle:Title',
             'choices' => $titles))
         ->add('detail', TextareaType::class, array('label' => 'Detalle / Observación','required' => false,
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


}
