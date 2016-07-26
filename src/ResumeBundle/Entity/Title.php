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
    * @ORM\OneToMany(targetEntity="History", mappedBy="title")
    */
    private $histories;


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
}
