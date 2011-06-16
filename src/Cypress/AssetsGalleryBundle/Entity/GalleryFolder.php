<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cypress\AssetsGalleryBundle\Entity\GalleryAsset;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Cypress\AssetsGalleryBundle\Entity\GalleryFolderRepository")
 * @ORM\Table(name="cypress_gallery_folders")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\JoinColumn(onDelete="cascade")
     */
    private $parent;
     
    /**
     * @ORM\OneToMany(targetEntity="GalleryFolder", mappedBy="parent")
     */
    private $children;
    
    /**
     * @ORM\Column(type="integer", nullable="false")
     */
    private $level;
    
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
     * @ORM\PrePersist
     */
    public function test()
    {
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
     * Get recursively the parents until root
     * @return array
     */
    public function getFullParentTree()
    {
        if ($this->isRoot()) {
            return array();
        }
        $tree = array();
        $tree[] = $this;
        $previuosFolder = $this->getParent();
        while (!$previuosFolder->isRoot()) {
            $tree[] = $previuosFolder;
            $previuosFolder = $previuosFolder->getParent();
        }
        return array_reverse($tree);
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

    /**
     * Set level
     *
     * @param integer $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return integer $level
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * return true if the folder is at first level
     * @return Boolean
     */
    public function isRoot()
    {
        return $this->getLevel() == 1;
    }
}