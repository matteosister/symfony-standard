<?php

/*
 * matteosister
 * just for fun...
 */

namespace Vivacom\CmsBundle\Entity;

/**
 * @orm:Entity
 * @orm:Table(name="page")
 */
class Page {
    
    /**
     * @orm:Column(type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @orm:Column
     */
    private $name;
    
    /**
     * @orm:Unique
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
}