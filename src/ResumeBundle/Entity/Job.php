<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
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
     * @ORM\Column(name="username", type="string",nullable=true)
     */
    private $username;


    /**
     * @var string
     *
     * @ORM\Column(name="lastusername", type="string",nullable=true)
     */
    private $lastusername;

    /**
     * @var string
     *
     * @ORM\Column(name="lastupdate", type="date",nullable=true)
     */
    private $lastupdate;


    /**
     * @var string
     *
     * @ORM\Column(name="created", type="date",nullable=true)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="integer",nullable=true)
     */
    private $version;




    /**
     * @var string
     *
     * @ORM\Column(name="hours", type="integer")
     */
    private $hours;


    /**
     * @ORM\ManyToOne(targetEntity="Profession", inversedBy="jobs")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     */
     private $profession;

     /**
      * @ORM\ManyToOne(targetEntity="Workplace", inversedBy="jobs")
      * @ORM\JoinColumn(name="workplace_id", referencedColumnName="id")
      */
     private $workplace;


     /**
     * @ORM\OneToMany(targetEntity="Assigment", mappedBy="job")
     */
     private $assigments;






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


    /**
     *  Get amount of day between dates
     *
     */
    public function getTotalDays()
    {
      $total = date_diff($this->startjob, $this->endjob)->format('%a')+1;
      return $total;
    }





    /**
     * Set lastusername
     *
     * @param string $lastusername
     *
     * @return Job
     */
    public function setLastusername($lastusername)
    {
        $this->lastusername = $lastusername;

        return $this;
    }

    /**
     * Get lastusername
     *
     * @return string
     */
    public function getLastusername()
    {
        return $this->lastusername;
    }

    /**
     * Set lastupdate
     *
     * @param \DateTime $lastupdate
     *
     * @return Job
     */
    public function setLastupdate($lastupdate)
    {
        $this->lastupdate = $lastupdate;

        return $this;
    }

    /**
     * Get lastupdate
     *
     * @return \DateTime
     */
    public function getLastupdate()
    {
        return $this->lastupdate;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Job
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Job
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->assigments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set profession
     *
     * @param \ResumeBundle\Entity\Profession $profession
     *
     * @return Job
     */
    public function setProfession(\ResumeBundle\Entity\Profession $profession = null)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return \ResumeBundle\Entity\Profession
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Add assigment
     *
     * @param \ResumeBundle\Entity\Assigment $assigment
     *
     * @return Job
     */
    public function addAssigment(\ResumeBundle\Entity\Assigment $assigment)
    {
        $this->assigments[] = $assigment;

        return $this;
    }

    /**
     * Remove assigment
     *
     * @param \ResumeBundle\Entity\Assigment $assigment
     */
    public function removeAssigment(\ResumeBundle\Entity\Assigment $assigment)
    {
        $this->assigments->removeElement($assigment);
    }

    /**
     * Get assigments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssigments()
    {
        return $this->assigments;
    }


    public function __toString() {
        return $this->name;
    }

}
