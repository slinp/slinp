<?php

namespace Slinp\Bundle\SlinpBundle\Util;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Translate node type names into other domains, e.g.
 * myfoo:barfoo => MyFooBundle:barfooAction
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class NodeTypeNameTranslator
{
    protected $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Translate to bundle namespace
     *
     * @param string $nodeTypeName
     *
     * @return string
     */
    public function toBundleNamespace($nodeTypeName)
    {
        $bundleName = ucfirst(strstr($nodeTypeName, ':', true));

        $bundle = $this->kernel->getBundle($bundleName . 'Bundle');

        return $bundle->getNamespace();
    }

    /**
     * Translate to controller fs path
     *
     * @param string $nodeTypeName
     *
     * @return string
     */
    public function toControllerPath($nodeTypeName)
    {
        $controllerName = ucfirst(substr(strstr($nodeTypeName, ':', false), 1));
        $controllerClass = sprintf('%s\\Controller\\%sController',
            $this->toBundleNamespace($nodeTypeName), $controllerName
        );
        $reflection = new \ReflectionClass($controllerClass);
        $controllerFilename = $reflection->getFileName();

        return $controllerFilename;
    }

    /**
     * Translate to a SlinpObject class name
     *
     * @param string $nodeTypeName
     *
     * @return string
     */
    public function toSlinpObject($nodeTypeName)
    {
        $objectName = ucfirst(substr(strstr($nodeTypeName, ':', false), 1));
        $objectClass = sprintf('%s\\SlinpObject\\%s',
            $this->toBundleNamespace($nodeTypeName), $objectName
        );

        return $objectClass;
    }
}
