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
     * @return string|null
     */
    public function toBundleNamespace($nodeTypeName)
    {
        $bundleName = ucfirst(strstr($nodeTypeName, ':', true));

        try {
            $bundle = $this->kernel->getBundle($bundleName . 'Bundle');
        } catch (\InvalidArgumentException $e) {
            return null;
        }

        return $bundle->getNamespace();
    }

    /**
     * Translate to controller fs path or return NULL
     * if controller does not exist.
     *
     * @param string $nodeTypeName
     *
     * @return string|null
     */
    public function toControllerPath($nodeTypeName)
    {
        $controllerName = ucfirst(substr(strstr($nodeTypeName, ':', false), 1));
        $controllerClass = sprintf('%s\\Controller\\%sController',
            $this->toBundleNamespace($nodeTypeName), $controllerName
        );

        if (!class_exists($controllerClass)) {
            return null;
        }

        $reflection = new \ReflectionClass($controllerClass);
        $controllerFilename = $reflection->getFileName();

        return $controllerFilename;
    }

    /**
     * Translate to a SlinpNode class name
     *
     * @param string $nodeTypeName
     *
     * @return string
     */
    public function toSlinpNode($nodeTypeName)
    {
        $objectName = ucfirst(substr(strstr($nodeTypeName, ':', false), 1));
        $objectClass = sprintf('%s\\SlinpNode\\%s',
            $this->toBundleNamespace($nodeTypeName), $objectName
        );

        return $objectClass;
    }
}
