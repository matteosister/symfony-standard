<?php

/*
 * matteosister
 * just for fun...
 */

namespace Vivacom\CmsBundle\Util;

class Util {
    
    protected $replacement;
    
    public function __construct($replacement = '-') {
        $this->replacement = $replacement;
    }
    
    public function slugify($slug)
    {
        // transliterate
		if (function_exists('iconv')) {
			$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
		}
		
		// lowercase
		if (function_exists('mb_strtolower')) {
			$slug = mb_strtolower($slug);
		} else {
			$slug = strtolower($slug);
		}
		
		// remove accents resulting from OSX's iconv
		$slug = str_replace(array('\'', '`', '^'), '', $slug);
		
		// replace non letter or digits with separator
		$slug = preg_replace('/\W+/', $this->replacement, $slug);
		
		// trim
		$slug = trim($slug, $this->replacement);
	
		if (empty($slug)) {
			return 'n-a';
		}
	
		return $slug;
    }
    
    static public function trimAt($string, $size = 50, $addDots = true)
    {
        $string = substr($string, 0, $size);
        if ($addDots) $string .= '...';
        return $string;
    }
}