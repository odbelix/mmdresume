<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Profession;
use ResumeBundle\Entity\Usertype;
use ResumeBundle\Form\ProfessionType;
use ResumeBundle\Controller\InfotextController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;


/**
 * Profession controller.
 *
 * @Route("/panel/profession")
 */
class ProfessionController extends Controller
{
    /**
     * Lists all Profession entities.
     *
     * @Route("/", name="panel_profession_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
              //$logger = $this->get('logger');
              //$logger->info('HIHI');

              $name = $request->request->get('form')['name'];
              $usertype = $request->request->get('form')['usertype'];
              
              //CHECKING IF VALUE EXISTS
              $repo = $this->getDoctrine()
                       ->getRepository('ResumeBundle:Profession');
              $query = $repo->createQueryBuilder('p')
                        ->where('p.name LIKE :name')
                        ->andwhere('p.usertype = '.$usertype)
                        ->setParameter('name', '%'.$name.'%')
                        ->getQuery();

              if ( count($query->getResult()) != 0 ){
                  $this->addFlash(
                    'error',
                    'El valor que se trata de ingresar esta duplicado'
                  );
                  return $this->redirectToRoute('panel_profession_index');
              }





              $ut = $em->getRepository('ResumeBundle:Usertype')->findOneById($usertype);
              if($ut){


                $newprofession = new Profession();
                $newprofession->setName($name);
                $newprofession->setUsertype($ut);



                $em = $this->getDoctrine()->getManager();
                $em->persist($newprofession);
                $em->flush();

                $this->addFlash(
                  'notice',
                  'La información fue guardada con exito'
                );
                $this->setShowCollapse($ut->getId());
              }
              else {
                $this->addFlash(
                  'error',
                  'Se debe seleccionar un tipo de Postulante'
                );


              }
              return $this->redirectToRoute('panel_profession_index');
        }

        //$professions = $em->getRepository('ResumeBundle:Profession')->findAll();
        $usertypes = $em->getRepository('ResumeBundle:Usertype')->findAll();
        $teachers = $em->getRepository('ResumeBundle:Profession')->findByUsertype(1);
        $techtops = $em->getRepository('ResumeBundle:Profession')->findByUsertype(2);
        $techmids = $em->getRepository('ResumeBundle:Profession')->findByUsertype(3);
        $professionals = $em->getRepository('ResumeBundle:Profession')->findByUsertype(5);

        $profession = new Profession();
        $form = $this->createFormBuilder($profession)
        ->setAction($this->generateUrl('panel_profession_index'))
        ->setMethod('POST')
        ->add('name',TextType::class,array('label' => 'Nombre de Título o Profesión',
              'attr' => array('class' => 'form-control')
            ))
        ->add('usertype',EntityType::class,array('label' => 'Tipo de Postulante',
             'required' => false,
             'placeholder' => 'Selecciona una opción',
             'attr' => array('class' => 'form-control'),
             'class' => 'ResumeBundle:Usertype'))
        ->getForm();

        return $this->render('profession/index.html.twig', array(
            'teachers' => $teachers,
            'techtops' => $techtops,
            'techmids' => $techmids,
            'professionals' => $professionals,
            'usertype' => $usertypes,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Profession entity.
     *
     * @Route("/new", name="panel_profession_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $profession = new Profession();
        $form = $this->createForm('ResumeBundle\Form\ProfessionType', $profession);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_profession');



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profession);
            $em->flush();

            //return $this->redirectToRoute('panel_profession_show', array('id' => $profession->getId()));
            return $this->redirectToRoute('panel_profession_index');
        }

        return $this->render('profession/new.html.twig', array(
            'profession' => $profession,
            'infotext' => $infotext->getText(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Profession entity.
     *
     * @Route("/{id}", name="panel_profession_show")
     * @Method("GET")
     */
    public function showAction(Profession $profession)
    {
        $deleteForm = $this->createDeleteForm($profession);

        return $this->render('profession/show.html.twig', array(
            'profession' => $profession,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Profession entity.
     *
     * @Route("/{id}/edit", name="panel_profession_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Profession $profession)
    {
        $deleteForm = $this->createDeleteForm($profession);
        $editForm = $this->createForm('ResumeBundle\Form\ProfessionType', $profession);
        $editForm->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_profession');



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profession);
            $em->flush();

            return $this->redirectToRoute('panel_profession_show', array('id' => $profession->getId()));
        }

        return $this->render('profession/edit.html.twig', array(
            'profession' => $profession,
            'infotext' => $infotext->getText(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Profession entity.
     *
     * @Route("/delete/{id}", name="panel_profession_delete_one")
     * @Method("GET")
     */
    public function deleteOneAction($id)
    {

      $user = $this->getUser();
      $this->validationAccessForUser($user);

      $em = $this->getDoctrine()->getManager();
      $prof = $em->getRepository('ResumeBundle:Profession')->findOneById($id);
      $ut = $prof->getUsertype();

      $this->setShowCollapse($ut->getId());

      try {
        $em->remove($prof);
        $em->flush();
        $this->addFlash(
          'notice',
          'La información fue eliminada con exito'
        );
      }
      catch(ForeignKeyConstraintViolationException $e){

        $this->addFlash(
          'error',
          'No se puede eliminar el título/profesión ['.$prof->getName().']. Este tiene un Trabajo o Título relacionado '
        );
      }

      return $this->redirectToRoute('panel_profession_index');
    }

    private function setShowCollapse($idusertype)
    {
      if ( $idusertype == 1 ){
          $show = 'teacher';
      }
      if ( $idusertype == 2 ){
          $show = 'techtop';
      }
      if ( $idusertype == 3 ){
          $show = 'techmid';
      }
      if ( $idusertype == 5 ){
          $show = 'professional';
      }
      $this->addFlash(
        'show',
        $show
      );
    }


    /**
     * Deletes a Profession entity.
     *
     * @Route("/{id}", name="panel_profession_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Profession $profession)
    {
        $form = $this->createDeleteForm($profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profession);
            $em->flush();
        }

        return $this->redirectToRoute('panel_profession_index');
    }

    /**
     * Creates a form to delete a Profession entity.
     *
     * @param Profession $profession The Profession entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profession $profession)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_profession_delete', array('id' => $profession->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    private function validationAccessForUser($user){
        if (!is_object($user)) {
          return $this->render('ResumeBundle:Default:index.html.twig');
        }
    }
}
