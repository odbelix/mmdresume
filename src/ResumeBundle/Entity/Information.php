<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Information
 *
 * @ORM\Table(name="information")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\InformationRepository")
 */
class Information
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
     * @ORM\Column(name="shortname", type="string", length=50, nullable=true, unique=true)
     */
    private $shortname;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=true, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=200, nullable=true, unique=true)
     */
    private $responsable;

    /**
     * @var string
     *
     * * @ORM\Column(name="signature", type="string", length=500, nullable=true, unique=true)
     */
    private $signature;

    /**
     * @var integer
     *
     * @ORM\Column(name="version", type="integer")
     */
    private $version;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="date")
     */
    private $creationdate;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastmodification", type="date")
     */
    private $lastmodification;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set shortname
     *
     * @param string $shortname
     *
     * @return Information
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * Get shortname
     *
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Information
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
     * Set message
     *
     * @param string $message
     *
     * @return Information
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Information
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
     * Set signature
     *
     * @param string $signature
     *
     * @return Information
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set version
     *
     * @param integer $version
     *
     * @return Information
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
     * Set creationdate
     *
     * @param \DateTime $creationdate
     *
     * @return Information
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    /**
     * Get creationdate
     *
     * @return \DateTime
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * Set lastmodification
     *
     * @param \DateTime $lastmodification
     *
     * @return Information
     */
    public function setLastmodification($lastmodification)
    {
        $this->lastmodification = $lastmodification;

        return $this;
    }

    /**
     * Get lastmodification
     *
     * @return \DateTime
     */
    public function getLastmodification()
    {
        return $this->lastmodification;
    }
}
