<?php

namespace Slinp\Component\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Slinp\Bundle\SlinpBundle\SlinpNode\Resource;

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
    
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }
    

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if ($name instanceof Resource) {
            $path = substr($name->getPath(), strlen($this->webRoot . '/root'));;
            if (!$path) {
                $path = '/';
            }

            return $path;
        }
    }
}
