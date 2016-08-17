<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Title
 *
 * @ORM\Table(name="title")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\TitleRepository")
 */
class Title
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
     * @var int
     *
     * @ORM\Column(name="idtitle", type="integer", length=2)
     */
    private $idtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="obtaining", type="string", length=4)
     */
    private $obtaining;

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer", length=4)
     */
    private $userid;

    /**
    * @ORM\OneToMany(targetEntity="Experience", mappedBy="title")
    */
    private $experiences;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="titles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
     private $user;


    /**
     * @ORM\ManyToOne(targetEntity="Profession", inversedBy="professions")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     */
     private $profession;






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
     * @return Title
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
     * Set idtitle
     *
     * @param integer $idtitle
     *
     * @return Title
     */
    public function setIdtitle($idtitle)
    {
        $this->idtitle = $idtitle;

        return $this;
    }

    /**
     * Get idtitle
     *
     * @return int
     */
    public function getIdtitle()
    {
        return $this->idtitle;
    }

    /**
     * Set obtaining
     *
     * @param \DateTime $obtaining
     *
     * @return Title
     */
    public function setObtaining($obtaining)
    {
        $this->obtaining = $obtaining;

        return $this;
    }

    /**
     * Get obtaining
     *
     * @return \DateTime
     */
    public function getObtaining()
    {
        return $this->obtaining;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Title
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    public function __toString() {
      return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->histories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add history
     *
     * @param \ResumeBundle\Entity\History $history
     *
     * @return Title
     */
    public function addHistory(\ResumeBundle\Entity\History $history)
    {
        $this->histories[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \ResumeBundle\Entity\History $history
     */
    public function removeHistory(\ResumeBundle\Entity\History $history)
    {
        $this->histories->removeElement($history);
    }

    /**
     * Get histories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistories()
    {
        return $this->histories;
    }

    /**
     * Add experience
     *
     * @param \ResumeBundle\Entity\Experience $experience
     *
     * @return Title
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
     * Add profession
     *
     * @param \ResumeBundle\Entity\Profession $profession
     *
     * @return Title
     */
    public function addProfession(\ResumeBundle\Entity\Profession $profession)
    {
        $this->professions[] = $profession;

        return $this;
    }

    /**
     * Remove profession
     *
     * @param \ResumeBundle\Entity\Profession $profession
     */
    public function removeProfession(\ResumeBundle\Entity\Profession $profession)
    {
        $this->professions->removeElement($profession);
    }

    /**
     * Get professions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfessions()
    {
        return $this->professions;
    }

    /**
     * Set profession
     *
     * @param \ResumeBundle\Entity\Profession $profession
     *
     * @return Title
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
     * Set user
     *
     * @param \ResumeBundle\Entity\User $user
     *
     * @return Title
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
}
