<?php

namespace Webit\Bundle\PdfLatexBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webit_pdf_latex');

        $fixOptionKeys = function ($options) {
            $fixedOptions = array();
            foreach ($options as $key => $value) {
                $fixedOptions[str_replace('_', '-', $key)] = $value;
            }
        
            return $fixedOptions;
        };
        
        $rootNode->children()
            ->scalarNode('binary')->defaultValue('pdflatex')->end()
            ->arrayNode('options')
                ->performNoDeepMerging()
                ->useAttributeAsKey('name')
                ->beforeNormalization()
                    ->always($fixOptionKeys)
                ->end()
                ->prototype('scalar')->end()
            ->end()
            ->arrayNode('env')
                ->prototype('scalar')->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
