<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Assigment
 *
 * @ORM\Table(name="assigment")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\AssigmentRepository")
 */
class Assigment
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
     * @ORM\Column(name="teacher", type="string", length=200, nullable=true, unique=true)
     */
    private $teacher;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateassigment", type="date")
     */
    private $dateassigment;

    /**
     * @var int
     *
     * @ORM\Column(name="version", type="integer")
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=100)
     */
    private $responsable;


    /**
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="assigments")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
     private $job;

     /**
      * @ORM\ManyToOne(targetEntity="User", inversedBy="assigments")
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
      */
      private $user;


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
     * Set teacher
     *
     * @param string $teacher
     *
     * @return Assigment
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return string
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Assigment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateassigment
     *
     * @param \DateTime $dateassigment
     *
     * @return Assigment
     */
    public function setDateassigment($dateassigment)
    {
        $this->dateassigment = $dateassigment;

        return $this;
    }

    /**
     * Get dateassigment
     *
     * @return \DateTime
     */
    public function getDateassigment()
    {
        return $this->dateassigment;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Assigment
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Assigment
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set job
     *
     * @param \ResumeBundle\Entity\Job $job
     *
     * @return Assigment
     */
    public function setJob(\ResumeBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \ResumeBundle\Entity\Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set user
     *
     * @param \ResumeBundle\Entity\User $user
     *
     * @return Assigment
     */
    public function setUser(\ResumeBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ResumeBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    public function __toString() {
        return $this->name;
    }

}
