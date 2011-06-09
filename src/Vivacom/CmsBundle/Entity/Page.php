<?php

/*
 * matteosister
 * just for fun...
 */
namespace Vivacom\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Vivacom\CmsBundle\Util\Util;
use Vivacom\CmsBundle\Entity\Meta;

/**
 * @ORM\Entity
 * @ORM\Table(name="cms_page")
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
     * @ORM\ManyToMany(targetEntity="Meta", inversedBy="pages")
     * @ORM\JoinTable(name="cms_page_meta")
     */
    private $metas;
    
    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function __construct($util = null) {
        if ($util == null) {
            $util = new Util();
        }
        $this->util = $util;
        $this->metas = new ArrayCollection();
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
    public function setMetas(Meta $meta)
    {
        $this->metas->add($meta);
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