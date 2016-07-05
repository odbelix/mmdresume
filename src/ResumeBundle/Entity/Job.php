<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\JobRepository")
 */
class Job
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
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=500)
     */
    private $detail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startjob", type="date")
     */
    private $startjob;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endjob", type="date")
     */
    private $endjob;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string")
     */
    private $username;


    /**
     * @var string
     *
     * @ORM\Column(name="hours", type="integer")
     */
    private $hours;




    /**
     * @ORM\ManyToOne(targetEntity="Speciality", inversedBy="jobs")
     * @ORM\JoinColumn(name="speciality_id", referencedColumnName="id")
     */
     private $speciality;

     /**
      * @ORM\ManyToOne(targetEntity="Workplace", inversedBy="workplaces")
      * @ORM\JoinColumn(name="workplace_id", referencedColumnName="id")
      */
     private $workplace;


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
     * @return Job
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

    /**
     * Set detail
     *
     * @param string $detail
     *
     * @return Job
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set startjob
     *
     * @param \DateTime $startjob
     *
     * @return Job
     */
    public function setStartjob($startjob)
    {
        $this->startjob = $startjob;

        return $this;
    }

    /**
     * Get startjob
     *
     * @return \DateTime
     */
    public function getStartjob()
    {
        return $this->startjob;
    }

    /**
     * Set endjob
     *
     * @param \DateTime $endjob
     *
     * @return Job
     */
    public function setEndjob($endjob)
    {
        $this->endjob = $endjob;

        return $this;
    }

    /**
     * Get endjob
     *
     * @return \DateTime
     */
    public function getEndjob()
    {
        return $this->endjob;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Job
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set speciality
     *
     * @param \ResumeBundle\Entity\Speciality $speciality
     *
     * @return Job
     */
    public function setSpeciality(\ResumeBundle\Entity\Speciality $speciality = null)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return \ResumeBundle\Entity\Speciality
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set workplace
     *
     * @param \ResumeBundle\Entity\Workplace $workplace
     *
     * @return Job
     */
    public function setWorkplace(\ResumeBundle\Entity\Workplace $workplace = null)
    {
        $this->workplace = $workplace;

        return $this;
    }

    /**
     * Get workplace
     *
     * @return \ResumeBundle\Entity\Workplace
     */
    public function getWorkplace()
    {
        return $this->workplace;
    }

    /**
     * Set hours
     *
     * @param integer $hours
     *
     * @return Job
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return integer
     */
    public function getHours()
    {
        return $this->hours;
    }
}
