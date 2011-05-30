<?php

/*
 * @matteosister
 * https://github.com/matteosister
 * Just for fun...
 */

/**
 * This Assetic filter uses the compass command line instead of the sass
 * It is useful if you use sprites icon generation, config.rb file etc.
 */

namespace Cypress\CompassGemBundle\Assetic\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;
use Assetic\Util\Process;


/**
 * @author matteosister
 */
class CompassGemFilter implements FilterInterface 
{
    private $compassPath;
    private $configFile;
    
    public function __construct($compassPath = '/usr/bin/compass', $compassConfigFile = '') {
        $this->compassPath = $compassPath;
        $this->configFile = $compassConfigFile;
    }
    
    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterLoad(AssetInterface $asset) 
    {
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterDump(AssetInterface $asset)
    {
        $options = array($this->compassPath);
        
        $root = $asset->getSourceRoot();
        $path = $asset->getSourcePath();
        
        $options[] = 'compile';
        
        // config file
        $configFile = tempnam(sys_get_temp_dir(), 'assetic_compass_gem_config');
        copy(dirname($root.'/'.$path).'/../'.$this->configFile, $configFile);
        $options[] = '-c';
        $options[] = $configFile;
        
        // input
        $options[] = $input = tempnam(sys_get_temp_dir(), 'assetic_compass_gem');
        file_put_contents($input, $asset->getContent());

        // output
        $options[] = $output = tempnam(sys_get_temp_dir(), 'assetic_compass_gem').'.rb';
        //$options[] = '/home/matteo/internet/sf2/src/Vivacom/CmsBundle/Resources/compass';
        
        $proc = new Process(implode(' ', array_map('escapeshellarg', $options)));
        
        $code = $proc->run();

        if (0 < $code) {
            //unlink($input);
            throw new \RuntimeException($proc->getErrorOutput());
        }

        $asset->setContent(file_get_contents($output).sys_get_temp_dir());
    }
}
