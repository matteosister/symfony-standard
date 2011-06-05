<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Vivacom\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Vivacom\CmsBundle\Util\Util;


/**
 * @ORM\Entity
 * @ORM\Table(name="cms_meta")
 */
class Meta {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(length=60)
     */
    private $name;
    
    /**
     * @ORM\Column(type="text", length=255)
     */
    private $content;
    
    /**
     * @ORM\ManyToMany(targetEntity="Page", mappedBy="metas")
     */
    private $pages;
    
    public function __construct($util = null) {
        $this->pages = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->name . ': \'' . Util::trimAt($this->content, 100) . '\'';
    }
    
    // ID
    public function getId() {
        return $this->id;
    }
    
    // NAME
    public function getName() {
        return $this->name;
    }
    public function setName($name) 
    {
        $this->name = $name;
    }
    
    // CONTENT
    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    
    // PAGES
    public function getPages() {
        return $this->pages;
    }
    public function setPages($pages) {
        $this->pages = $pages;
    }
}

