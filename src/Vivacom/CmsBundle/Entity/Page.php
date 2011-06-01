<?php

/*
 * matteosister
 * just for fun...
 */
namespace Vivacom\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vivacom\CmsBundle\Util\Util;

/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 * @ORM\HasLifecycleCallbacks
 */
class Page {
    
    private $util;
    
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
     * @ORM\Column(unique=true)
     */
    private $url;
    
    /**
     * @ORM\Column(type="array")
     */
    private $metas;
    
    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function __construct() {
        $this->util = new Util();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if ($this->url == null) {
            $this->url = $this->util->slugify($this->name);
        }
    }
    
    // ID
    public function getId()
    {
        return $this->id;
    }
    
    // NAME
    public function getName()
    {
        return $this->name;
    }
    public function setName($name) 
    {
        $this->name = $name;
    }
    
    // URL
    public function getUrl()
    {
        return $this->url;
    }
    public function setUrl($val) 
    {
        $this->url = $val;
    }
    
    // METAS
    public function getMetas()
    {
        return $this->metas;
    }
    public function setMetas($metas)
    {
        $this->metas = $metas;
    }
    
    // CONTENT
    public function getContent() 
    {
        return $this->content;
    }
    
    public function setContent($content) {
        $this->content = $content;
    }
}