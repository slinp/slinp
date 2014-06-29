<?php

namespace Slinp\Bundle\SlinpAdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Slinp\Bundle\SlinpAdminBundle\DependencyInjection\Compiler\AddTemplateDirectoryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SlinpAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddTemplateDirectoryPass());
    }
}

