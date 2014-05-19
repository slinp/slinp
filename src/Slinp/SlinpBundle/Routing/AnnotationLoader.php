<?php

namespace Slinp\SlinpBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;

class AnnotationLoader extends Loader
{
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function load($resource, $type = null)
    {

    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && preg_match('{^(.*?):(.*?)/?(.*)?$}', $resource);
    }
}
