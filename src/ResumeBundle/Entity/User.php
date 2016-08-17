<?php
// src/ResumeBundle/Entity/User.php

namespace ResumeBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        //$this->addRole("ROLE_POSTULANT");
    }
    /**
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $firstname;
    /**
     * @ORM\Column(type="string",length=100,nullable=true,nullable=true)
     */
    protected $middlename;

    /**
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $momlastname;

    /**
     * @ORM\Column(type="datetime",length=2,nullable=true)
     */
    protected $birthdate;

    /**
     * @ORM\Column(type="string",length=15,nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string",length=15,nullable=true)
     */
    protected $celphone;

    /**
     * @ORM\Column(type="string",length=500,nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $gender;


    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $rut;

    /**
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $usertype;

    /**
     * @ORM\Column(type="integer",length=100,nullable=true)
     */
    protected $usertypeid;



    /**
    * @ORM\OneToMany(targetEntity="Assigment", mappedBy="user")
    */
    private $assigments;

    /**
    * @ORM\OneToMany(targetEntity="Experience", mappedBy="user")
    */
    private $experiences;


    /**
    * @ORM\OneToMany(targetEntity="Title", mappedBy="user")
    */
    private $titles;


    /**
    * @ORM\OneToMany(targetEntity="TeacherDirector", mappedBy="user")
    */
    private $heads;


    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set middlename
     *
     * @param string $middlename
     *
     * @return User
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;

        return $this;
    }

    /**
     * Get middlename
     *
     * @return string
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set momlastname
     *
     * @param string $momlastname
     *
     * @return User
     */
    public function setMomlastname($momlastname)
    {
        $this->momlastname = $momlastname;

        return $this;
    }

    /**
     * Get momlastname
     *
     * @return string
     */
    public function getMomlastname()
    {
        return $this->momlastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set celphone
     *
     * @param string $celphone
     *
     * @return User
     */
    public function setCelphone($celphone)
    {
        $this->celphone = $celphone;

        return $this;
    }

    /**
     * Get celphone
     *
     * @return string
     */
    public function getCelphone()
    {
        return $this->celphone;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set rut
     *
     * @param string $rut
     *
     * @return User
     */
    public function setRut($rut)
    {
        $this->rut = $rut;

        return $this;
    }

    /**
     * Get rut
     *
     * @return string
     */
    public function getRut()
    {
        return $this->rut;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return User
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set usertype
     *
     * @param string $usertype
     *
     * @return User
     */
    public function setUsertype($usertype)
    {
        $this->usertype = $usertype;

        return $this;
    }

    /**
     * Get usertype
     *
     * @return string
     */
    public function getUsertype()
    {
        return $this->usertype;
    }

    /**
     * Set usertypeid
     *
     * @param integer $usertypeid
     *
     * @return User
     */
    public function setUsertypeid($usertypeid)
    {
        $this->usertypeid = $usertypeid;

        return $this;
    }

    /**
     * Get usertypeid
     *
     * @return integer
     */
    public function getUsertypeid()
    {
        return $this->usertypeid;
    }

    /**
     * Add assigment
     *
     * @param \ResumeBundle\Entity\Assigment $assigment
     *
     * @return User
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

    /**
     * Add experience
     *
     * @param \ResumeBundle\Entity\Experience $experience
     *
     * @return User
     */
    public function addExperience(\ResumeBundle\Entity\Experience $experience)
    {
        $this->experiences[] = $experience;

        return $this;
    }

    /**
     * Remove experience
     *
     * @param \ResumeBundle\Entity\Experience $experience
     */
    public function removeExperience(\ResumeBundle\Entity\Experience $experience)
    {
        $this->experiences->removeElement($experience);
    }

    /**
     * Get experiences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExperiences()
    {
        return $this->experiences;
    }

    /**
     * Add title
     *
     * @param \ResumeBundle\Entity\Title $title
     *
     * @return User
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

    /**
     * Add head
     *
     * @param \ResumeBundle\Entity\TeacherDirector $head
     *
     * @return User
     */
    public function addHead(\ResumeBundle\Entity\TeacherDirector $head)
    {
        $this->heads[] = $head;

        return $this;
    }

    /**
     * Remove head
     *
     * @param \ResumeBundle\Entity\TeacherDirector $head
     */
    public function removeHead(\ResumeBundle\Entity\TeacherDirector $head)
    {
        $this->heads->removeElement($head);
    }

    /**
     * Get heads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHeads()
    {
        return $this->heads;
    }
}
