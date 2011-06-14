<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cypress\AssetsGalleryBundle\Entity\GalleryFolder;

/**
 * @ORM\Entity
 * @ORM\Table(name="cypress_gallery_assets")
 */
class GalleryAsset {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column
     */
    private $name;
    
    /**
     * @ORM\Column
     */
    private $filename;
    
    /**
     * @ORM\Column
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="GalleryFolder", inversedBy="asset")
     */
    private $folder;
    

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set filename
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     *
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set folder
     *
     * @param Cypress\AssetsGalleryBundle\Entity\GalleryFolder $folder
     */
    public function setFolder(GalleryFolder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * Get folder
     *
     * @return Cypress\AssetsGalleryBundle\Entity\GalleryFolder $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }
}