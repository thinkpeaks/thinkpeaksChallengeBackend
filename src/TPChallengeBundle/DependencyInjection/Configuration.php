<?php

namespace App\TPChallengeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements \Symfony\Component\Config\Definition\ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('tp_challenge');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('noreply_address')->end()
                ->scalarNode('receiver_address')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
