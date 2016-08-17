<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeacherDirector
 *
 * @ORM\Table(name="teacher_director")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\TeacherDirectorRepository")
 */
class TeacherDirector
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
     * @ORM\Column(name="other", type="string", length=300,nullable=true)
     */
    private $other;

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
     * @ORM\ManyToOne(targetEntity="Workplace", inversedBy="heads")
     * @ORM\JoinColumn(name="workplace_id", referencedColumnName="id")
     */
    private $workplace;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="heads")
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
     * Set workplace
     *
     * @param string $workplace
     *
     * @return TeacherDirector
     */
    public function setWorkplace($workplace)
    {
        $this->workplace = $workplace;

        return $this;
    }

    /**
     * Get workplace
     *
     * @return string
     */
    public function getWorkplace()
    {
        return $this->workplace;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return TeacherDirector
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
     * @return TeacherDirector
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
     * Set other
     *
     * @param string $other
     *
     * @return TeacherDirector
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

    /**
     * Set user
     *
     * @param \ResumeBundle\Entity\User $user
     *
     * @return TeacherDirector
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
