<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usertype
 *
 * @ORM\Table(name="usertype")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\UsertypeRepository")
 */
class Usertype
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
     * @ORM\Column(name="name", type="string", length=100, nullable=true, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string")
     */
    private $detail;


    /**
    * @ORM\OneToMany(targetEntity="Profession", mappedBy="usertype")
    */
    private $professions;


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
     * @return Usertype
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
     * @return Usertype
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

    public function __toString() {
      return $this->name;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->professions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add profession
     *
     * @param \ResumeBundle\Entity\Profession $profession
     *
     * @return Usertype
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
}
