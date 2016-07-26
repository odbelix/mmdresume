<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Workplace
 *
 * @ORM\Table(name="workplace")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\WorkplaceRepository")
 */
class Workplace
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
     * @ORM\Column(name="address", type="string", length=300)
     */
    private $address;

    /**
    * @ORM\OneToMany(targetEntity="Job", mappedBy="workplace")
    */
    private $jobs;

    /**
    * @ORM\OneToMany(targetEntity="History", mappedBy="workplace")
    */
    private $history;


    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=300)
     */
    private $responsable;


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
     * @return Workplace
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
     * Set address
     *
     * @param string $address
     *
     * @return Workplace
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
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add job
     *
     * @param \ResumeBundle\Entity\Job $job
     *
     * @return Workplace
     */
    public function addJob(\ResumeBundle\Entity\Job $job)
    {
        $this->jobs[] = $job;

        return $this;
    }

    /**
     * Remove job
     *
     * @param \ResumeBundle\Entity\Job $job
     */
    public function removeJob(\ResumeBundle\Entity\Job $job)
    {
        $this->jobs->removeElement($job);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }
    public function __toString() {
        return $this->name;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return Workplace
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
     * Add history
     *
     * @param \ResumeBundle\Entity\History $history
     *
     * @return Workplace
     */
    public function addHistory(\ResumeBundle\Entity\History $history)
    {
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \ResumeBundle\Entity\History $history
     */
    public function removeHistory(\ResumeBundle\Entity\History $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistory()
    {
        return $this->history;
    }
}
