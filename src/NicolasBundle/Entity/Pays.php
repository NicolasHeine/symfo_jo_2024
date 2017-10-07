<?php

namespace NicolasBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * @ORM\Entity(repositoryClass="NicolasBundle\Repository\PaysRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Pays
{
    const UPLOAD_DIR = __DIR__ . '/../../../web/uploads/flags';

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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_url", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $flagUrl;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NicolasBundle\Entity\Athlete", mappedBy="pays", cascade={"persist", "remove"})
     */
    protected $athletes;

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
     * @return Pays
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
     * Set flagUrl
     *
     * @param string $flagUrl
     *
     * @return Pays
     */
    public function setFlagUrl($flagUrl)
    {
        $this->flagUrl = $flagUrl;

        return $this;
    }

    /**
     * Get flagUrl
     *
     * @return string
     */
    public function getFlagUrl()
    {
        return $this->flagUrl;
    }

    /**
     * @return ArrayCollection
     */
    public function getAthletes()
    {
        return $this->athletes;
    }

    /**
     * @param ArrayCollection $athletes
     */
    public function setAthletes($athletes)
    {
        $this->athletes = $athletes;
    }

    /**
     * @ORM\PostRemove
     */
    public function deleteImage(){
        if(file_exists(self::UPLOAD_DIR.'/'.$this->flagUrl)){
            unlink(self::UPLOAD_DIR.'/'.$this->flagUrl);
        }
        return true;
    }
}

