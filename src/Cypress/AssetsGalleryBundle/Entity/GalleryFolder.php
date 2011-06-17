<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as GEDMO;
use Cypress\AssetsGalleryBundle\Entity\GalleryAsset;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @GEDMO\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
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
     * @GEDMO\TreeParent
     * @ORM\ManyToOne(targetEntity="GalleryFolder", inversedBy="children")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parent;
    
    /**
     * @ORM\Column(type="integer")
     * @GEDMO\TreeLeft
     */
    private $lft;
    
    /**
     * @ORM\Column(type="integer")
     * @GEDMO\TreeRight
     */
    private $rgt;
    
    /**
     * @GEDMO\TreeLevel
     * @ORM\Column(type="integer", nullable="false")
     */
    private $level;
     
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
     * Indented name
     * useful for entity form field
     */
    public function getIndentedName()
    {
        return str_repeat('--', $this->getLevel()) . $this;
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
        return $this->getLft() == 1;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * Get lft
     *
     * @return integer $lft
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    /**
     * Get rgt
     *
     * @return integer $rgt
     */
    public function getRgt()
    {
        return $this->rgt;
    }
}