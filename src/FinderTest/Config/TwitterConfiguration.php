<?php
namespace FinderTest\Config;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
/**
 * Description of TwitterConfiguration
 *
 * @author guillermo
 */
class TwitterConfiguration implements ConfigurationInterface {
    
    
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('twitter');
        $rootNode
            ->children()
                ->scalarNode('consumer_key')->isRequired()->end()
                ->scalarNode('consumer_secret')->isRequired()->end()
                ->scalarNode('access_token')->isRequired()->end()
                ->scalarNode('access_token_secret')->isRequired()->end()
            ->end();
        return $treeBuilder;
    }

}
