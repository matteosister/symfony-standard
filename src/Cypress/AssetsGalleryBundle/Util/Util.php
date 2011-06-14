<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Util;

class Util {
    
    public function generateToken()
    {
        return $token = md5(uniqid(rand(),1));
    }
}