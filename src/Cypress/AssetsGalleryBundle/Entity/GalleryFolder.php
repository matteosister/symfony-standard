<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Cypress\AssetsGalleryBundle\Entity\GalleryAsset;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\Table(name="cypress_gallery_folders")
 */
class GalleryFolder {
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
    private $relative_path;
    
    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;
    
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;
    
    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;
     
    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(type="integer")
     */
    private $root;
     
    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="GalleryFolder", inversedBy="children")
     */
    private $parent;
     
    /**
     * @ORM\OneToMany(targetEntity="GalleryFolder", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;
    
    /**
     * @ORM\OneToMany(targetEntity="GalleryAsset", mappedBy="folder")
     * @ORM\OrderBy({"name" = "ASC"});
     */
    private $asset;
    
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
     * Set relative_path
     *
     * @param string $relativePath
     */
    public function setRelativePath($relativePath)
    {
        $this->relative_path = $relativePath;
    }

    /**
     * Get relative_path
     *
     * @return string $relativePath
     */
    public function getRelativePath()
    {
        return $this->relative_path;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * Get lvl
     *
     * @return integer $lvl
     */
    public function getLvl()
    {
        return $this->lvl;
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

    /**
     * Set root
     *
     * @param integer $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * Get root
     *
     * @return integer $root
     */
    public function getRoot()
    {
        return $this->root;
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