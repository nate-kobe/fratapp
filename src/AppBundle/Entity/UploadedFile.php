<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UploadedFile
 * @ORM\MappedSuperclass 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UploadedFileRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"design_culte" = "UploadedFileDesignCulte"})
 */
abstract class UploadedFile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    protected $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="text")
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="filetype", type="string", length=255)
     */
    protected $filetype;

    /**
     * Temporary variable to handle file upload
     */
    protected $file;

    /* GETTER and SETTERS */
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title) {$this->title = $title;}
    public function getTitle() {return $this->title;}

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return UploadedFile
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return UploadedFile
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set filetype
     *
     * @param string $filetype
     *
     * @return UploadedFile
     */
    public function setFiletype($filetype)
    {
        $this->filetype = $filetype;

        return $this;
    }

    /**
     * Get filetype
     *
     * @return string
     */
    public function getFiletype()
    {
        return $this->filetype;
    }

    public function getFile() {return $this->file;}
    public function setFile($f) {$this->file = $f;}
}

