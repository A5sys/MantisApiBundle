<?php

namespace A5sys\MantisApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('mantis_api')->children()
            ->scalarNode('login')->isRequired()->end()
            ->scalarNode('password')->isRequired()->end()
            ->scalarNode('url')->isRequired()->end()
        ->end();

        return $treeBuilder;
    }
}
