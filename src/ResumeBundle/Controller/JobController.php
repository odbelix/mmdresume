<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Job;
use ResumeBundle\Entity\Usertype;
use ResumeBundle\Form\JobType;
use ResumeBundle\Form\TeacherType;
use ResumeBundle\Form\TechtopType;
use ResumeBundle\Form\TechmidType;
use ResumeBundle\Form\SchoolType;
use ResumeBundle\Form\ProfessionalType;
use ResumeBundle\Controller\InfotextController;

/**
 * Job controller.
 *
 * @Route("/panel/job")
 */
class JobController extends Controller
{
    protected $menu='jobs';
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="panel_job_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
          //

          $formname = $request->request->keys()[0];

          $name = $request->request->get($formname)['name'];
          $detail = $request->request->get($formname)['detail'];
          $startjob = $request->request->get($formname)['startjob'];
          $endjob = $request->request->get($formname)['endjob'];


          if(array_key_exists('profession',$request->request->get($formname))){
              $profession = $request->request->get($formname)['profession'];
              $professionEntity = $em->getRepository('ResumeBundle:Profession')->findOneById($profession);
          }
          else {
              $professionEntity = null;
          }
          $hours = $request->request->get($formname)['hours'];
          $workplace = $request->request->get($formname)['workplace'];

          $wp = $em->getRepository('ResumeBundle:Workplace')->findOneById($workplace);
          if ( $wp ) {
            $newJob = new Job();
            $newJob->setName($name);
            $newJob->setDetail($detail);
            $newJob->setStartjob(new \Datetime($startjob));
            $newJob->setEndjob(new \Datetime($endjob));
            $newJob->setProfession($professionEntity);
            $newJob->setHours($hours);
            $newJob->setWorkplace($wp);

            //FOR THE CREATION
            $newJob->setUsername($this->getUser());
            $newJob->setLastusername($this->getUser());
            $newJob->setCreated(new \DateTime('now'));
            $newJob->setLastupdate(new \DateTime('now'));
            $newJob->setVersion(1);



            $em->persist($newJob);
            $em->flush();

            $this->addFlash(
              'notice',
              'La información fue guardada con exito'
            );
          }
          else {
            $this->addFlash(
              'error',
              'Se debe selecionar un Establecimiento como Lugar de Trabajo'
            );
          }


          return $this->redirectToRoute('panel_job_index');
        }


        $jobs = $em->getRepository('ResumeBundle:Job')->findAll();
        $usertypes = $em->getRepository('ResumeBundle:Usertype')->findAll();

        $job = new Job();
        $formteacher = $this->createForm('ResumeBundle\Form\TeacherType', $job);
        $formtechtop = $this->createForm('ResumeBundle\Form\TechtopType', $job);
        $formtechmid = $this->createForm('ResumeBundle\Form\TechmidType', $job);
        $formschool = $this->createForm('ResumeBundle\Form\SchoolType', $job);
        $formprofessional = $this->createForm('ResumeBundle\Form\ProfessionalType', $job);



        return $this->render('job/index.html.twig', array(
            'jobs' => $jobs,
            'formteacher' => $formteacher->createView(),
            'formtechtop' => $formtechtop->createView(),
            'formtechmid' => $formtechmid->createView(),
            'formschool' => $formschool->createView(),
            'formprofessional' => $formprofessional->createView(),
            'usertypes' => $usertypes,
        ));
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/new", name="panel_job_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm('ResumeBundle\Form\JobType', $job);
        $form->handleRequest($request);

        /*Recovering the Infotext*/
        $em = $this->getDoctrine()->getManager();
        $infotext = $em->getRepository('ResumeBundle:Infotext')->findOneByShortname('infotext_job');


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //FOR THE CREATION
            $job->setUsername($this->getUser());
            $job->setLastusername($this->getUser());
            $job->setCreated(new \DateTime('now'));
            $job->setLastupdate(new \DateTime('now'));
            $job->setVersion(1);

            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('panel_job_show', array('id' => $job->getId()));
        }

        return $this->render('job/new.html.twig', array(
            'job' => $job,
            'infotext' => $infotext->getText(),
            'menu' => $this->getMyMenu(),
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{id}", name="panel_job_show")
     * @Method("GET")
     */
    public function showAction(Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $days = $job->getTotalDays();
        return $this->render('job/show.html.twig', array(
            'job' => $job,
            'days' => $days,
            'menu' => $this->getMyMenu(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and displays a Job entity.
     *
     * @Route("/assigment/{id}", name="panel_job_assigment")
     * @Method("GET")
     */
    public function jobAssigmentAction(Job $job)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($job);

        $profession = $job->getProfession();
        $postulants = $em->getRepository('ResumeBundle:User')->findByUsertypeid($profession->getUsertype());

        $days = $job->getTotalDays();
        return $this->render('job/jobassigment.html.twig', array(
            'job' => $job,
            'postulants' => $postulants,
            'days' => $days,
        ));
    }



    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="panel_job_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm('ResumeBundle\Form\JobType', $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $job->setLastusername($this->getUser());
            $job->setLastupdate(new \DateTime('now'));
            $job->setVersion($job->getVersion()+1);

            $em->persist($job);
            $em->flush();

            $this->addFlash(
                  'notice',
                  'La información fue editada con exito'
            );


            return $this->redirectToRoute('panel_job_show', array('id' => $job->getId()));



        }

        return $this->render('job/edit.html.twig', array(
            'job' => $job,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}", name="panel_job_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }
        $this->addFlash(
              'notice',
              'La información fue eliminada con exito'
        );
        return $this->redirectToRoute('panel_job_index');
    }

    /**
     * Creates a form to delete a Job entity.
     *
     * @param Job $job The Job entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panel_job_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function getMyMenu(){
        return $this->menu;
    }

    private function getCurrentUserName(){
      $user = $this->getUser();
      return $user->getCurrentUserName();
    }


}
