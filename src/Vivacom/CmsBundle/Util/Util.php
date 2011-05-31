<?php

/*
 * matteosister
 * just for fun...
 */

namespace Vivacom\CmsBundle\Util;

class Util {
    
    protected $em;
    
    public function __construct($em) {
        $this->em = $em;
    }
    public function getPippo()
    {
        return 'pippo';
    }
}