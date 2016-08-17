<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profession
 *
 * @ORM\Table(name="profession")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\ProfessionRepository")
 */
class Profession
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Usertype", inversedBy="professions")
     * @ORM\JoinColumn(name="usertype_id", referencedColumnName="id")
     */
     private $usertype;


      /**
      * @ORM\OneToMany(targetEntity="Title", mappedBy="profession")
      */
      private $titles;



     /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="profession")
     */
     private $jobs;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Profession
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString() {
      return $this->name;
    }

    /**
     * Set usertype
     *
     * @param \ResumeBundle\Entity\usertype $usertype
     *
     * @return Profession
     */
    public function setUsertype(\ResumeBundle\Entity\usertype $usertype = null)
    {
        $this->usertype = $usertype;

        return $this;
    }

    /**
     * Get usertype
     *
     * @return \ResumeBundle\Entity\usertype
     */
    public function getUsertype()
    {
        return $this->usertype;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add job
     *
     * @param \ResumeBundle\Entity\Job $job
     *
     * @return Profession
     */
    public function addJob(\ResumeBundle\Entity\Job $job)
    {
        $this->jobs[] = $job;

        return $this;
    }

    /**
     * Remove job
     *
     * @param \ResumeBundle\Entity\Job $job
     */
    public function removeJob(\ResumeBundle\Entity\Job $job)
    {
        $this->jobs->removeElement($job);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set title
     *
     * @param \ResumeBundle\Entity\Title $title
     *
     * @return Profession
     */
    public function setTitle(\ResumeBundle\Entity\Title $title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \ResumeBundle\Entity\Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add title
     *
     * @param \ResumeBundle\Entity\Title $title
     *
     * @return Profession
     */
    public function addTitle(\ResumeBundle\Entity\Title $title)
    {
        $this->titles[] = $title;

        return $this;
    }

    /**
     * Remove title
     *
     * @param \ResumeBundle\Entity\Title $title
     */
    public function removeTitle(\ResumeBundle\Entity\Title $title)
    {
        $this->titles->removeElement($title);
    }

    /**
     * Get titles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTitles()
    {
        return $this->titles;
    }
}
