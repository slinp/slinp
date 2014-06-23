<?php

namespace Slinp\Bundle\SlinpBundle\DependencyInjection;

use Slinp\Bundle\SlinpBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SlinpExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('routing.xml');
        $loader->load('content.xml');
        $loader->load('imagine.xml');
        $loader->load('slinp.xml');
        $loader->load('node-mapper.xml');
        $loader->load('twig.xml');
    }

    public function getName()
    {
        return 'slinp';
    }
}
