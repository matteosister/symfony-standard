<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

namespace Cypress\AssetsGalleryBundle\Twig;

class FiltersExtension extends \Twig_Extension {
    
    public function getFilters()
    {
        return array(
            'trim_at_space' => new \Twig_Filter_Method($this, 'trimAtSpace'),
        );
    }
    
    public function getName() {
        return 'assets_library';
    }
    
    /**
    * String trim
    *
    * @param Stringa $string
    * @param int $maxSize
    * @return stringa tagliata
    */
    public function trimAtSpace($string, $maxSize = 35, $addDots = true, $strip_tags = true) {
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