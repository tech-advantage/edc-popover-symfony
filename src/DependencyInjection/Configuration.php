<?php


namespace Techad\EdcPopoverBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('techad_edc_popover');
        $rootNode = $treeBuilder->getRootNode();
        $this->addServerSection($rootNode);
        $this->addPopoverSection($rootNode);
        return $treeBuilder;
    }

    private function addServerSection(ArrayNodeDefinition $node)
    {
        $node->children()
            ->arrayNode('server')
            ->children()
            ->scalarNode('url')->defaultValue('http://localhost')->info('the edc web help url')->end()
            ->scalarNode('help_context')->defaultValue("help")->info('the context url for the web help')->end()
            ->end()
            ->end()
            ->end();
    }

    private function addPopoverSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('popover')
            ->children()
            ->booleanNode('summary')->defaultTrue()->info('the context url for the web help')->end()
            ->scalarNode('default_language')->defaultValue('en')->info('the default language')->end()
            ->end()
            ->end()
            ->end();
    }
}
