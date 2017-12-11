<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UploadedFileDesignCulte
 *
 * @ORM\Table(name="uploaded_file_design_culte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UploadedFileDesignCulteRepository")
 */
class UploadedFileDesignCulte extends UploadedFile
{
    /**
     * @ORM\ManyToOne(targetEntity="Culte", inversedBy="images")
     */
    private $culte;

    public function getCulte() {return $this->culte;}
    public function setCulte($culte) {
        $this->culte = $culte;
        $culte->addImages($this);
    }
}

