<?php


namespace Techad\EdcPopoverBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EdcPopoverExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

         // Define server parameters
        if (array_key_exists('server', $config)) {
            $serverConfigs = $config['server'];
            $container->setParameter('edc_popover.server.url', $serverConfigs['url']);
            $container->setParameter('edc_popover.server.help_context', $serverConfigs['help_context']);
        }
        // define the popover parameters
        if (array_key_exists('popover', $config)) {
            $popoverConfigs = $config['popover'];
            $container->setParameter('edc_popover.popover.summary', $popoverConfigs['summary']);
        }
    }

    public function getAlias()
    {
        return 'techad_edc_popover';
    }

}
