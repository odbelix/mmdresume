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
     * @var string
     *
     * @ORM\Column(name="teacher", type="string", length=20)
     */
    private $teacher;


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
    
    /**
     * Set teacher
     *
     * @param string $teacher
     *
     * @return TeacherFile
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return string
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}
