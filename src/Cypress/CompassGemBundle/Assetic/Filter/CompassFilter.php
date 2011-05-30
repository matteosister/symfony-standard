<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2011 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cypress\CompassGemBundle\Assetic\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;
use Assetic\Util\Process;

/**
 * Loads Compass files.
 *
 * @author Maxime Thirouin <maxime.thirouin@gmail.com>
 */
class CompassFilter implements FilterInterface
{
    private $compassPath;
    private $scss;

    // sass options
    private $unixNewlines;
    private $debugInfo;
    private $cacheLocation;
    private $noCache;

    // compass options
    private $config;
    private $style;
    private $quiet;
    private $noLineComments;
    private $imagesDir;
    private $javascriptsDir;

    // compass configuration file options
    private $loadPaths = array();
    private $httpPath;
    private $httpImagesPath;
    private $httpJavascriptsPath;
    
    public function __construct($compassPath = '/usr/bin/compass')
    {
        $this->compassPath = $compassPath;
        $this->cacheLocation = sys_get_temp_dir();
    }

    public function setScss($scss)
    {
        $this->scss = $scss;
    }

    // sass options setters
    public function setUnixNewlines($unixNewlines)
    {
        $this->unixNewlines = $unixNewlines;
    }

    public function setDebugInfo($debugInfo)
    {
        $this->debugInfo = $debugInfo;
    }

    public function setCacheLocation($cacheLocation)
    {
        $this->cacheLocation = $cacheLocation;
    }

    public function setNoCache($noCache)
    {
        $this->noCache = $noCache;
    }

    // compass options setters
    public function setStyle($style)
    {
        $this->style = $style;
    }

    public function setQuiet($quiet)
    {
        $this->quiet = $quiet;
    }

    public function setNoLineComments($noLineComments)
    {
        $this->noLineComments = $noLineComments;
    }
    
    public function setImagesDir($imagesDir)
    {
        $this->imagesDir = $imagesDir;
    }

    public function setJavascriptsDir($javascriptsDir)
    {
        $this->javascriptsDir = $javascriptsDir;
    }

    // compass configuration file options setters
    public function addLoadPath($loadPath)
    {
        $this->loadPaths[] = $loadPath;
    }

    public function setHttpPath($httpPath)
    {
        $this->httpPath = $httpPath;
    }
    
    public function setHttpImagesPath($httpImagesPath)
    {
        $this->httpImagesPath = $httpImagesPath;
    }
    
    public function setHttpJavascriptsPath($httpJavascriptsPath)
    {
        $this->httpJavascriptsPath = $httpJavascriptsPath;
    }

    public function filterLoad(AssetInterface $asset)
    {
        $root = $asset->getSourceRoot();
        $path = $asset->getSourcePath();

        if ($root && $path) {
            $this->loadPaths[] = dirname($root . '/' . $path);
        }
        
        $options = array(
            $this->compassPath,
            'compile'
        );

        if ($this->style) {
            $options[] = '--output-style';
            $options[] = $this->style;
        }

        if ($this->quiet) {
            $options[] = '--quiet';
        }

        if ($this->noLineComments) {
            $options[] = '--no-line-comments';
        }

        // these two options are not passed into the config file
        // because like this, compass adapts this to be xxx_dir or xxx_path
        // whether it's an absolute path or not
        if ($this->imagesDir) {
            $options[] = '--images-dir';
            $options[] = $this->imagesDir;
        }

        if ($this->javascriptsDir) {
            $options[] = '--javascripts-dir';
            $options[] = $this->javascriptsDir;
        }

        // options in config file
        $optionsConfig = array(
            'sass_options' => array()
        );

        if (!empty($this->loadPaths)) {
            $optionsConfig['additional_import_paths'] = $this->loadPaths;
        }

        if ($this->unixNewlines) {
            $optionsConfig['sass_options']['unix_newlines'] = true;
        }

        if ($this->cacheLocation) {
            $optionsConfig['sass_options']['cache_location'] = $this->cacheLocation;
        }

        if ($this->noCache) {
            $optionsConfig['sass_options']['no_cache'] = true;
        }

        if ($this->httpPath) {
            $optionsConfig['http_path'] = $this->httpPath;
        }

        if ($this->httpImagesPath) {
            $optionsConfig['http_images_path'] = $this->httpImagesPath;
        }

        if ($this->httpJavascriptsPath) {
            $optionsConfig['http_javascripts_path'] = $this->httpJavascriptsPath;
        }

        // compass does not seems to handle symlink, so we use realpath()
        $tempDir = realpath(sys_get_temp_dir());

        // options in configuration file
        if (count($optionsConfig)) {
            $config = array();
            foreach($optionsConfig as $name => $value) {
                if (!is_array($value)) {
                    $config[] = sprintf('%s = "%s"', $name, $value);
                }
                elseif (!empty($value)) {
                    $config[] = sprintf('%s = %s', $name, $this->formatArrayToRuby($value));
                }
            }

            $config = implode("\n", $config) . "\n";
            echo $config;
            $this->config = tempnam($tempDir, 'assetic_compass');
            file_put_contents($this->config, $config);
        }

        if ($this->config) {
            $options[] = '--config';
            $options[] = $this->config;
        }

        $options[] = '--sass-dir';
        $options[] = $tempDir;
        $options[] = '--css-dir';
        $options[] = $tempDir;

        // compass choose the type (sass or scss from the filename)
        if ($path) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
        }
        else {
            $type = $this->scss ? 'scss' : 'sass';
        }

        $tempName = tempnam($tempDir, 'assetic_compass');

        // input
        $options[] = $input =  ($tempName . '.' . $type);
        file_put_contents($input, $asset->getContent());

        // output
        $output = $tempName . '.css';
        //echo implode(' ', array_map('escapeshellarg', $options));
        $proc = new Process(
            'export HOME=' . $_SERVER['DOCUMENT_ROOT'] . '; ' .  // it's not really usefull but... https://github.com/chriseppstein/compass/issues/376
            implode(' ', array_map('escapeshellarg', $options))
        );
        $code = $proc->run();

        if (0 < $code) {
            unlink($input);
            throw new \RuntimeException($proc->getErrorOutput());
        }

        $asset->setContent(file_get_contents($output));

        //unlink($input);
        //unlink($output);
        if (is_file($this->config)) {
            //unlink($this->config);
        }
    }

    public function filterDump(AssetInterface $asset)
    {
    }

    private function formatArrayToRuby($array)
    {
        $output = array();

        // does we have an associative array ?
        if (count(array_filter(array_keys($array), "is_numeric")) != count($array))
        {
            foreach($array as $name => $value) {
                $output[] = sprintf('    :%s => "%s"', $name, $value);
            }
            $output = "{\n". implode(",\n", $output) . "\n}";
        }
        else
        {
            foreach($array as $name => $value) {
                $output[] = sprintf('    "%s"', $value);
            }
            $output = "[\n". implode(",\n", $output) . "\n]";
        }

        return $output;
    }
}
