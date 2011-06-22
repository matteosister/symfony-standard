<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     *  @Assert\File(maxSize="15000000")
     */
    public $file;
    
    /**
     * @ORM\Column
     */
    private $filename;
    
    /**
     * @ORM\ManyToOne(targetEntity="GalleryFolder", inversedBy="asset")
     */
    private $folder;
    
    /**
     * @ORM\Column(nullable=true)
     */
    private $description;
    
    /**
     * @ORM\Column(nullable=true)
     */
    private $mimetype;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $is_image;
    
    public function __construct() {
        $this->is_image = false;
    }
    
    public function __toString() {
        return $this->name;
    }

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
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string $file
     */
    public function getFile()
    {
        return $this->file;
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
     * Set mime-type
     *
     * @param string $description
     */
    public function setMimetype($mimetype)
    {
        $this->setIsImage(strpos($mimetype, 'image') !== false);
        $this->mimetype = $mimetype;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * Set is_image
     *
     * @param boolean $isImage
     */
    public function setIsImage($isImage)
    {
        $this->is_image = $isImage;
    }

    /**
     * Get is_image
     *
     * @return boolean $isImage
     */
    public function getIsImage()
    {
        return $this->is_image;
    }
}