<?php

namespace NicolasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Athlete
 *
 * @ORM\Table(name="athlete")
 * @ORM\Entity(repositoryClass="NicolasBundle\Repository\AthleteRepository")
 */
class Athlete
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
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="datetime")
     * @Assert\NotBlank()
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var Discipline
     *
     * @ORM\ManyToOne(targetEntity="NicolasBundle\Entity\Discipline", inversedBy="athletes", cascade={"persist"})
     * @ORM\JoinColumn(name="id_discipline", referencedColumnName="id")
     */
    private $discipline;

    /**
     * @var Pays
     *
     * @ORM\ManyToOne(targetEntity="NicolasBundle\Entity\Pays", inversedBy="athletes", cascade={"persist"})
     * @ORM\JoinColumn(name="id_pays", referencedColumnName="id")
     */
    private $pays;

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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Athlete
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Athlete
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Athlete
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Athlete
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * @param Discipline $discipline
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;
    }

    /**
     * @return Pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param Pays $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }
}

