<?php

namespace Slinp\Bundle\SlinpAdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Stolen from the KnpMenuBundle
 */
class AddTemplateDirectoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $loaderDefinition = null;

        if ($container->hasDefinition('twig.loader.filesystem')) {
            $loaderDefinition = $container->getDefinition('twig.loader.filesystem');
        }

        if (null === $loaderDefinition) {
            return;
        }

        $refl = new \ReflectionClass('Slinp\Component\AdminBuilder\AdminFactory');
        $path = dirname($refl->getFileName()).'/Resources/views';
        $loaderDefinition->addMethodCall('addPath', array($path));
    }
}
