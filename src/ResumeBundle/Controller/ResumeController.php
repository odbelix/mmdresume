<?php

namespace ResumeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormFactory;

use ResumeBundle\Entity\Workplace;
use ResumeBundle\Entity\User;
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
        $titles = $em->getRepository('ResumeBundle:Title')->findAll();
        $workplaces = $em->getRepository('ResumeBundle:Workplace')->findAll();

        $listtitle = $this->getListOfTitleAccordingTypeUser($user->getUsertypeid());

        $titles = $em->getRepository('ResumeBundle:Title')->findBy(
        array('userid' => $user->getId()), array('obtaining' => 'DESC'));

        $experiences = $em->getRepository('ResumeBundle:History')->findBy(
        array('userid' => $user->getId()), array('startdate' => 'DESC'));


        $formprof = $this->createFormProfForAssistantType($user->getUsertypeid());
        $formexp = $this->createFormExpForAssistantType($user->getUsertypeid(),$titles,$workplaces);

        return $this->render('resume/myresume.html.twig', array(
            'user' => $user,
            'titles' => $titles,
            'exps' => $experiences,
            'new_form_prof' => $formprof->createView(),
            'new_form_exp' => $formexp->createView(),
            'listtitle' => $listtitle,
          ));

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

          var_dump($title);
          var_dump($other);

          $newTitle = new Title();
          $title = $this->getTitleFromSelection($user->getUsertypeid(),$title);
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

      if ($request->isMethod('POST')) {
        //GETTING INFORMATION FROM POST REQUEST FORM
        $name = $request->request->get('form')['name'];
        $detail = $request->request->get('form')['detail'];
        $workplace = $request->request->get('form')['workplace'];
        $other = $request->request->get('form')['other'];
        $startdate = $request->request->get('form')['startdate'];
        $enddate = $request->request->get('form')['enddate'];

        //INSERT TITLE
        $newHistory = new History();
        $title = $this->getTitleFromUser($user->getId(),$name);
        $workplace_name = $this->getWorkplaceFromSelection($workplace);

        $newHistory->setName($title->getName());
        $newHistory->setIdtitle($title->getId());
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

      return $this->redirectToRoute('resume_resume_index');

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
    protected function getTitleFromSelection($idusertype,$idselected){
        $em = $this->getDoctrine()->getManager();
        if ( $idusertype == 1 ){
          $result = $em->getRepository('ResumeBundle:Speciality')->findOneById($idselected);
        }
        if ( $idusertype == 2 ){
          $result = $em->getRepository('ResumeBundle:TechnicianTop')->findOneById($idselected);
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
          $classForm = 'ResumeBundle:TechnicianTop';
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
    protected function createFormExpForAssistantType($idusertype,$titles,$workplaces){
      $result = null;
      $classForm = '';
      $classWorkplace = "ResumeBundle:Workplace";

      $em = $this->getDoctrine()->getManager();

      if ( $idusertype == 1 ){
          $classForm = 'ResumeBundle:Speciality';
      }
      if ( $idusertype == 2 ){
          $classForm = 'ResumeBundle:TechnicianTop';
      }
      if ( $idusertype == 3 ){
          $classForm = 'ResumeBundle:TechnicianMid';
      }
      if ( $idusertype == 4 ){

      }
      //PROFESIONAL
      if ( $idusertype == 5 ){
        $classForm = 'ResumeBundle:Title';
      }
      //FORM

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
}
