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
            ->booleanNode('verify_peer')->defaultTrue()->end()
            ->booleanNode('verify_peer_name')->defaultTrue()->end()
            ->booleanNode('allow_self_signed')->defaultFalse()->end()
        ->end();

        return $treeBuilder;
    }
}
