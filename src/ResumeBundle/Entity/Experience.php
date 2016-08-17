<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Experience
 *
 * @ORM\Table(name="experience")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\ExperienceRepository")
 */
class Experience
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
     * @ORM\Column(name="detail", type="string", length=300, nullable=true)
     */
    private $detail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date")
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date",nullable=true)
     */
    private $enddate;

    /**
     * @ORM\ManyToOne(targetEntity="Title", inversedBy="experiences")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Workplace", inversedBy="experiences")
     * @ORM\JoinColumn(name="workplace_id", referencedColumnName="id")
     */
    private $workplace;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="experiences")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
     private $user;


     /**
      * @var string
      *
      * @ORM\Column(name="other", type="string", length=300, nullable=true)
      */
    private $other;


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
     * Set detail
     *
     * @param string $detail
     *
     * @return Experience
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
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return Experience
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return Experience
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set title
     *
     * @param \ResumeBundle\Entity\Title $title
     *
     * @return Experience
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
     * Set workplace
     *
     * @param \ResumeBundle\Entity\Workplace $workplace
     *
     * @return Experience
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
     * Set user
     *
     * @param \ResumeBundle\Entity\User $user
     *
     * @return Experience
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

    /**
     * Set other
     *
     * @param string $other
     *
     * @return Experience
     */
    public function setOther($other)
    {
        $this->other = $other;

        return $this;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }
}
