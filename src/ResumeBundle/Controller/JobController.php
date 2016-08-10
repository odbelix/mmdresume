<?php

namespace ResumeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ResumeBundle\Entity\Job;
use ResumeBundle\Entity\Usertype;
use ResumeBundle\Form\JobType;
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
          $this->addFlash(
            'notice',
            'La información fue guardada con exito'
          );
          return $this->redirectToRoute('panel_job_index');
        }


        $jobs = $em->getRepository('ResumeBundle:Job')->findAll();
        $usertypes = $em->getRepository('ResumeBundle:Usertype')->findAll();

        $job = new Job();
        $form = $this->createForm('ResumeBundle\Form\JobType', $job);


        return $this->render('job/index.html.twig', array(
            'jobs' => $jobs,
            'form' => $form->createView(),
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

            return $this->redirectToRoute('panel_job_show', array('id' => $job->getId()));
            //return $this->redirectToRoute('panel_job_edit', array('id' => $job->getId()));
        }

        return $this->render('job/edit.html.twig', array(
            'job' => $job,
            'menu' => $this->getMyMenu(),
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
