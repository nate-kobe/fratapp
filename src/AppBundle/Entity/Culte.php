<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

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
     * @ORM\OneToMany(targetEntity="UploadedFileDesignCulte", mappedBy="culte")
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $sono;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $band;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $bandRehearsal;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $president;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $structure;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infos;

    private $instruments;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $instrumentsStr;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $worshipStructure;

    /**
     * @ORM\ManyToMany(targetEntity="Song", inversedBy="cultes")
     */
    private $songs;

    /* CONSTRUCTOR */
    public function __construct()
    {
        $this->instruments = new ArrayCollection();
        $this->instrumentsStr = new ArrayCollection();
        $this->songs = new ArrayCollection();
    }


    /* GETTERS AND SETTERS */

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTitle() {return $this->title;}
    public function setTitle($title) {$this->title = $title;}

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

    public function getPresident() {return $this->president;}
    public function setPresident($president) {$this->president = $president;}

    public function getSermon() {return $this->sermon;}
    public function setSermon($sermon) {$this->sermon = $sermon;}

    public function getPresentation() {return $this->presentation;}
    public function setPresentation($presentation) {$this->presentation = $presentation;}

    public function getImages() {return $this->images;}
    public function addImages($img) {$this->images[] = $img;}

    public function getSono() {return $this->sono;}
    public function setSono(User $user) {$this->sono = $user;}

    public function getStructure() {return $this->structure;}
    public function setStructure($str) {$this->structure = $str;}

    public function getBand() {return $this->band;}
    public function setBand($band) {$this->band = $band;}

    public function getInfos() {return $this->infos;}
    public function setInfos($infos) {$this->infos = $infos;}

    public function getBandRehearsal() {return $this->bandRehearsal;}
    public function setBandRehearsal($bandRehearsal) {$this->bandRehearsal = $bandRehearsal;}

    public function getInstruments() {return $this->instruments;}
    public function setInstruments($i) {$this->instruments = $i;}
    public function addInstruments($i) {$this->instruments[] = $i; $i->addCultes($this);}

    public function getInstrumentsStr() {return $this->instrumentsStr;}
    public function addInstrumentsStr($istr) {return $this->instrumentsStr[] = $istr;}

    public function getWorshipStructure() {return $this->worshipStructure;}
    public function setWorshipStructure($ws) {$this->worshipStructure = $ws;}

    public function getSongs() {return $this->songs;}
    public function addSongs($song) {$this->songs[] = $song; $song->addCultes($this);}
}
