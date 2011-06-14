<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cypress\AssetsGalleryBundle\DependencyInjection;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author Kris Wallsmith <kris@symfony.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $finder = new ExecutableFinder();
        
        $builder->root('cypress_gallery')
            ->children()
                ->variableNode('base_path')->isRequired()->end()
            ->end();
        
        return $builder;

//        $builder->root('assetic')
//            ->children()
//                ->booleanNode('debug')->defaultValue($this->debug)->end()
//                ->booleanNode('use_controller')->defaultValue($this->debug)->end()
//                ->scalarNode('read_from')->defaultValue('%kernel.root_dir%/../web')->end()
//                ->scalarNode('write_to')->defaultValue('%assetic.read_from%')->end()
//                ->scalarNode('java')->defaultValue($finder->find('java', '/usr/bin/java'))->end()
//                ->scalarNode('node')->defaultValue($finder->find('node', '/usr/bin/node'))->end()
//                ->scalarNode('sass')->defaultValue($finder->find('sass', '/usr/bin/sass'))->end()
//            ->end()
//
//            // bundles
//            ->fixXmlConfig('bundle')
//            ->children()
//                ->arrayNode('bundles')
//                    ->defaultValue($this->bundles)
//                    ->requiresAtLeastOneElement()
//                    ->prototype('scalar')
//                        ->validate()
//                            ->ifNotInArray($this->bundles)
//                            ->thenInvalid('%s is not a valid bundle.')
//                        ->end()
//                    ->end()
//                ->end()
//            ->end()
//
//            // assets
//            ->fixXmlConfig('asset')
//            ->children()
//                ->arrayNode('assets')
//                    ->addDefaultsIfNotSet()
//                    ->requiresAtLeastOneElement()
//                    ->useAttributeAsKey('name')
//                    ->prototype('array')
//                        ->beforeNormalization()
//                            // a scalar is a simple formula of one input file
//                            ->ifTrue(function($v) { return !is_array($v); })
//                            ->then(function($v) { return array('inputs' => array($v)); })
//                        ->end()
//                        ->beforeNormalization()
//                            ->always()
//                            ->then(function($v)
//                            {
//                                // cast scalars as array
//                                foreach (array('input', 'inputs', 'filter', 'filters') as $key) {
//                                    if (isset($v[$key]) && !is_array($v[$key])) {
//                                        $v[$key] = array($v[$key]);
//                                    }
//                                }
//
//                                // organize arbitrary options
//                                foreach ($v as $key => $value) {
//                                    if (!in_array($key, array('input', 'inputs', 'filter', 'filters', 'option', 'options'))) {
//                                        $v['options'][$key] = $value;
//                                        unset($v[$key]);
//                                    }
//                                }
//
//                                return $v;
//                            })
//                        ->end()
//
//                        // the formula
//                        ->fixXmlConfig('input')
//                        ->fixXmlConfig('filter')
//                        ->children()
//                            ->arrayNode('inputs')
//                                ->prototype('scalar')->end()
//                            ->end()
//                            ->arrayNode('filters')
//                                ->prototype('scalar')->end()
//                            ->end()
//                            ->arrayNode('options')
//                                ->useAttributeAsKey('name')
//                                ->prototype('variable')->end()
//                            ->end()
//                        ->end()
//                    ->end()
//                ->end()
//            ->end()
//
//            // filters
//            ->fixXmlConfig('filter')
//            ->children()
//                ->arrayNode('filters')
//                    ->addDefaultsIfNotSet()
//                    ->requiresAtLeastOneElement()
//                    ->useAttributeAsKey('name')
//                    ->prototype('variable')
//                        ->treatNullLike(array())
//                        ->validate()
//                            ->ifTrue(function($v) { return !is_array($v); })
//                            ->thenInvalid('The assetic.filters config %s must be either null or an array.')
//                        ->end()
//                    ->end()
//                ->end()
//            ->end()
//
//            // twig
//            ->children()
//                ->arrayNode('twig')
//                    ->addDefaultsIfNotSet()
//                    ->defaultValue(array())
//                    ->fixXmlConfig('function')
//                    ->children()
//                        ->arrayNode('functions')
//                            ->addDefaultsIfNotSet()
//                            ->defaultValue(array())
//                            ->useAttributeAsKey('name')
//                            ->prototype('variable')
//                                ->treatNullLike(array())
//                                ->validate()
//                                    ->ifTrue(function($v) { return !is_array($v); })
//                                    ->thenInvalid('The assetic.twig.functions config %s must be either null or an array.')
//                                ->end()
//                            ->end()
//                        ->end()
//                    ->end()
//                ->end()
//            ->end()
//        ;
    }
}
