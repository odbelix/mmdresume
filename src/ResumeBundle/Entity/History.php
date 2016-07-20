<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\HistoryRepository")
 */
class History
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
     * @ORM\Column(name="detail", type="string", length=100,nullable=true)
     */
    private $detail;


    /**
     * @var string
     *
     * @ORM\Column(name="workplace", type="string", length=100,nullable=true)
     */
    private $workplace;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="string", length=100,nullable=true)
     */
    private $other;



    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer", length=4)
     */
    private $userid;


    /**
     * @var int
     *
     * @ORM\Column(name="idtitle", type="integer", length=2)
     */
    private $idtitle;

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
     * @return History
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
     * @return History
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
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return History
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
     * @return History
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
     * Set detail
     *
     * @param string $detail
     *
     * @return History
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
     * Set userid
     *
     * @param integer $userid
     *
     * @return History
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

    /**
     * Set workplace
     *
     * @param string $workplace
     *
     * @return History
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
     * Set other
     *
     * @param string $other
     *
     * @return History
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
