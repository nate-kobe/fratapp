<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instrument
 *
 * @ORM\Table(name="instrument")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InstrumentRepository")
 */
class Instrument
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    private $cultes;

    /* CONSTRUCTOR */
    public function __construct()
    {
        $this->cultes = new ArrayCollection();
    }


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
     * @return Instrument
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

    /* DO NOT USE. use $culte->addInstrument instead */
    public function getCultes() {return $this->cultes;}
    public function addCultes($c) {$this->cultes[] = $c;}
}

