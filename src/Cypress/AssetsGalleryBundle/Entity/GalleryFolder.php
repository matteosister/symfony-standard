<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Gedmo\Mapping\Annotation as GEDMO;
use Doctrine\ORM\Mapping as ORM;
use Cypress\AssetsGalleryBundle\Entity\GalleryAsset;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cypress_gallery_folders")
 */
class GalleryFolder
{
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
     * @ORM\ManyToOne(targetEntity="GalleryFolder", inversedBy="children")
     */
    private $parent;
     
    /**
     * @ORM\OneToMany(targetEntity="GalleryFolder", mappedBy="parent")
     */
    private $children;
    
    /**
     * @ORM\OneToMany(targetEntity="GalleryAsset", mappedBy="folder")
     * @ORM\OrderBy({"name" = "ASC"});
     */
    private $asset;
    
    public function __toString() {
        return $this->getName();
    }
    
    public function __construct()
    {
        $this->children = new ArrayCollection();
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
     * Set parent
     *
     * @param Cypress\AssetsGalleryBundle\Entity\GalleryFolder $parent
     */
    public function setParent(GalleryFolder $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Cypress\AssetsGalleryBundle\Entity\GalleryFolder $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Cypress\AssetsGalleryBundle\Entity\GalleryFolder $children
     */
    public function addChildren(GalleryFolder $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection $children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add asset
     *
     * @param Cypress\AssetsGalleryBundle\Entity\GalleryAsset $asset
     */
    public function addAsset(GalleryAsset $asset)
    {
        $this->asset[] = $asset;
    }

    /**
     * Get asset
     *
     * @return Doctrine\Common\Collections\Collection $asset
     */
    public function getAsset()
    {
        return $this->asset;
    }
}