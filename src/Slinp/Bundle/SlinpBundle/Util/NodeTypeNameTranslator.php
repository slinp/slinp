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
    protected $namespaceTransposition = array(
        'nt' => 'slinp',
    );

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Exchange one namespace for another. For example the default
     * "nt" namespace to the "slinp" namespace.
     *
     * @param string $namespace
     *
     * @return string
     */
    private function transposeNamespace($namespace)
    {
        if (isset($this->namespaceTransposition[$namespace])) {
            return $this->namespaceTransposition[$namespace];
        }

        return $namespace;
    }

    /**
     * Return the bundle name for a given node type.
     *
     * @param string $nodeTypeName
     *
     * @return string
     */
    public function toBundleName($nodeTypeName)
    {
        $namespace = strstr($nodeTypeName, ':', true);
        $namespace = $this->transposeNamespace($namespace);
        $bundleName = ucfirst($namespace);
        $bundleName .= 'Bundle';

        return $bundleName;
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
        $bundleName = $this->toBundleName($nodeTypeName);

        try {
            $bundle = $this->kernel->getBundle($bundleName);
        } catch (\InvalidArgumentException $e) {
            return null;
        }

        return $bundle->getNamespace();
    }

    public function toControllerName($nodeTypeName)
    {
        $controllerName = ucfirst(substr(strstr($nodeTypeName, ':', false), 1));

        return $controllerName;
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
        $controllerName = $this->toControllerName($nodeTypeName);
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

    public function getBundleName($argument1)
    {
        // TODO: write logic here
    }
}
