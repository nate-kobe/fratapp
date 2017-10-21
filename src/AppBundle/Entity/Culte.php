<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Culte
 *
 * @ORM\Table(name="culte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CulteRepository")
 */
class Culte
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="preacher", type="string", length=50, nullable=true)
     */
    private $preacher;

    /**
     * @ORM\Column(name="sermon", type="string", length=255, nullable=true)
     */
    private $sermon;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $banner;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $sono;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $band;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $structure;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stScene;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Culte
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getPreacher() {return $this->preacher;}
    public function setPreacher($preacher) {$this->preacher = $preacher;}

    public function getSermon() {return $this->sermon;}
    public function setSermon($sermon) {$this->sermon = $sermon;}

    public function getPresentation() {return $this->presentation;}
    public function setPresentation($presentation) {$this->presentation = $presentation;}

    public function getBanner() {return $this->banner;}
    public function setBanner($banner) {$this->banner = $banner;}

    public function getSono() {return $this->sono;}
    public function setSono(User $user) {$this->sono = $user;}

    public function getStructure() {return $this->structure;}
    public function setStructure($str) {$this->structure = $str;}

    public function getStScene() {return $this->stScene;}
    public function setStScene($scene) {$this->stScene = $scene;}

    public function getBand() {return $this->band;}
    public function setBand($band) {$this->band = $band;}
}
