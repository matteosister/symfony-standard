<?php

/*
 * matteosister
 * just for fun...
 */
namespace Vivacom\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page {
    
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
    
    public function getId()
    {
        return $this->id;
    }
    
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getUrl() {
        return $this->url;
    }
    public function setUrl($val) {
        $this->url = $val;
    }
}