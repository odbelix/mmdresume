<?php

namespace ResumeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeacherFile
 *
 * @ORM\Table(name="teacher_file")
 * @ORM\Entity(repositoryClass="ResumeBundle\Repository\TeacherFileRepository")
 */
class TeacherFile
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
     * @var int
     *
     * @ORM\Column(name="catholic", type="integer", length=1)
     */
    private $catholic;

    /**
     * @var int
     *
     * @ORM\Column(name="evangelical", type="integer", length=1)
     */
    private $evangelical;


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
     * Set catholic
     *
     * @param integer $catholic
     *
     * @return TeacherFile
     */
    public function setCatholic($catholic)
    {
        $this->catholic = $catholic;

        return $this;
    }

    /**
     * Get catholic
     *
     * @return int
     */
    public function getCatholic()
    {
        return $this->catholic;
    }

    /**
     * Set evangelical
     *
     * @param integer $evangelical
     *
     * @return TeacherFile
     */
    public function setEvangelical($evangelical)
    {
        $this->evangelical = $evangelical;

        return $this;
    }

    /**
     * Get evangelical
     *
     * @return int
     */
    public function getEvangelical()
    {
        return $this->evangelical;
    }
}

