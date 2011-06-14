<?php

/*
 * matteosister
 * just for fun...
 */

namespace Cypress\AssetsGalleryBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Exception\UnsetKeyException;
use Cypress\AssetsGalleryBundle\DependencyInjection\Configuration;

class AssetsGalleryExtension extends Extension {
    
    public function load(array $config, ContainerBuilder $container) {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('gallery_bundle.xml');
        
        $config = self::processConfigs($config);
        
        $container->setParameter('assets_gallery.base_path', $config['base_path']);
    }
    
    /**
     * Merges the user's config arrays.
     *
     * @param array   $configs An array of config arrays
     *
     * @return array The merged config
     */
    static protected function processConfigs(array $configs)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        return $processor->processConfiguration($configuration, $configs);
    }
    
    public function getAlias() {
        return 'assets_gallery';
    }
}