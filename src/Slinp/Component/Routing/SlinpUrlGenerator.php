<?php

namespace Slinp\Component\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Slinp\Component\NodeMapper\SlinpNodeInterface;

/**
 * URL generator for Slinp nodes.
 *
 * NOTE: This is pretty dumb at the moment and only returns
 *       the web path of the resource, it does not support
 *       any additional routes that may be defined in the controller.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class SlinpUrlGenerator implements UrlGeneratorInterface
{
    protected $context;
    protected $webRoot;

    public function __construct($webRoot)
    {
        $this->webRoot = $webRoot;
    }

    public function getContext() 
    {
        return $this->context;
    }
    
    public function supports($name)
    {
        return $name instanceof SlinpNodeInterface;
    }

    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }
    
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if ($name instanceof SlinpNodeInterface) {
            $path = substr($name->node()->getPath(), strlen($this->webRoot . '/root'));
            if (!$path) {
                $path = '/';
            }

            return $path;
        }
    }
}
