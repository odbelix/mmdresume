<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Workplace;
use ResumeBundle\Form\WorkplaceType;
use ResumeBundle\Controller\InfotextController;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

/**
 * Workplace controller.
 *
 * @Route("/panel/workplace")
 */
class WorkplaceController extends Controller
{
    protected $menu = "workplace";
    /**
     * Lists all Workplace entities.
     *
     * @Route("/", name="panel_workplace_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

          $name = $request->request->get('workplace')['name'];
          $address = $request->request->get('workplace')['address'];
          $responsable = $request->request->get('workplace')['responsable'];

          //CHECKING IF VALUE EXISTS
          $repo = $this->getDoctrine()
                   ->getRepository('ResumeBundle:Workplace');
          $query = $repo->createQueryBuilder('p')
                    ->where('p.name LIKE :name')
                    ->setParameter('name', '%'.$name.'%')
                    ->getQuery();

          if ( count($query->getResult()) != 0 ){
            $this->addFlash(
              'error',
              'El valor que se trata de ingresar esta duplicado'
            );
            return $this->redirectToRoute('panel_workplace_index');
          }


          $wp = new Workplace();
          $wp->setName($name);
          $wp->setAddress($address);
          $wp->setResponsable($responsable);

          $em->persist($wp);
          $em->flush();
          $this->addFlash(
            'notice',
            'La información fue guardada con exito'
          );

        }

        $workplaces = $em->getRepository('ResumeBundle:Workplace')->findAll();

        $workplace = new Workplace();
        $form = $this->createForm('ResumeBundle\Form\WorkplaceType', $workplace);

        return $this->render('workplace/index.html.twig', array(
            'workplaces' => $workplaces,
            'form' => $form->createView(),
            'menu' => $this->getMyMenu(),
        ));
    }

    /**
     * Creates a new Workplace entity.
     *
     * @Route("/new", name="panel_workplace_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $workplace = new Workplace();
        $form = $this->createForm('ResumeBundle\Form\WorkplaceType', $workplace);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_workplace');



        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workplace);
            $em->flush();

            return $this->redirectToRoute('panel_workplace_show', array('id' => $workplace->getId()));
        }

        return $this->render('workplace/new.html.twig', array(
            'workplace' => $workplace,
            'infotext' => $infotext->getText(),
            'menu' => $this->getMyMenu(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a Profession entity.
     *
     * @Route("/delete/{id}", name="panel_workplace_delete_one")
     * @Method("GET")
     */
    public function deleteOneAction($id)
    {

      $user = $this->getUser();
      $em = $this->getDoctrine()->getManager();
      $wp = $em->getRepository('ResumeBundle:Workplace')->findOneById($id);

      try {
        $em->remove($wp);
        $em->flush();
        $this->addFlash(
          'notice',
          'La información fue eliminada con exito'
        );
      }
      catch(ForeignKeyConstraintViolationException $e){

        $this->addFlash(
          'error',
          'No se puede eliminar el Establecimiento ['.$wp->getName().']. Este tiene un Trabajo o Experiencia Laboral'
        );
      }

      return $this->redirectToRoute('panel_workplace_index');

    }




    /**
     * Finds and displays a Workplace entity.
     *
     * @Route("/{id}", name="panel_workplace_show")
     * @Method("GET")
     */
    public function showAction(Workplace $workplace)
    {
        $deleteForm = $this->createDeleteForm($workplace);

        return $this->render('workplace/show.html.twig', array(
            'workplace' => $workplace,
            'menu' => $this->getMyMenu(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Workplace entity.
     *
     * @Route("/{id}/edit", name="panel_workplace_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Workplace $workplace)
    {
        $deleteForm = $this->createDeleteForm($workplace);
        $editForm = $this->createForm('ResumeBundle\Form\WorkplaceType', $workplace);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workplace);
            $em->flush();

            return $this->redirectToRoute('panel_workplace_edit', array('id' => $workplace->getId()));
        }

        return $this->render('workplace/edit.html.twig', array(
            'workplace' => $workplace,
            'menu' => $this->getMyMenu(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Workplace entity.
     *
     * @Route("/{id}", name="panel_workplace_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Workplace $workplace)
    {
        $form = $this->createDeleteForm($workplace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {

            $em = $this->getDoctrine()->getManager();
            $em->remove($workplace);
            $em->flush();
            $this->addFlash(
              'notice',
              'La información fue eliminada con Exito'
            );

            }
            catch(ForeignKeyConstraintViolationException $e){
              $this->addFlash(
                'error',
                'No se puede eliminar el Establecimiento ['.$workplace->getName().']. Este tiene un Trabajo o Experiencia Laboral relacionado'
              );
            }
        }

        return $this->redirectToRoute('panel_workplace_index');
    }

    /**
     * Creates a form to delete a Workplace entity.
     *
     * @param Workplace $workplace The Workplace entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Workplace $workplace)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_workplace_delete', array('id' => $workplace->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getMyMenu(){
      return $this->menu;
    }

}
