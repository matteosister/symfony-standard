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
    
    /**
    * String trim
    *
    * @param Stringa $string
    * @param int $maxSize
    * @return stringa tagliata
    */
    public function trimAtSpace($string, $maxSize, $addDots = true, $strip_tags = true) {
        $strlen = strlen($string);
        if ($strlen <= $maxSize) {
            return $strip_tags ? strip_tags($string) : $string;
        } else {
            $new_string = substr($string, 0, $maxSize - 3);
            $pos = strrpos($new_string, ' ');
            if ($pos === FALSE) {
                $output = $new_string;
            } else {
                $output = substr($new_string, 0, $pos);
            }
            if ($strip_tags) $output = strip_tags($output);
            return $addDots ? $output.'...' : $output;
        }
    }
}