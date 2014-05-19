<?php

namespace Slinp\SlinpBundle\Routing;

use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;

class SlinpResourceMatcher implements RequestMatcherInterface
{
    protected $registry;
    protected $webPath;

    public function __construct(
        ManagerRegistry $registry, 
        $webPath)
    {
        $this->registry = $registry;
        $this->webPath = $webPath;
    }

    public function matchRequest(Request $request)
    {
        $session = $this->registry->getConnection();

        $pathInfo = $request->getPathInfo();

        if ($pathInfo == '/') {
            $pathInfo = '';
        }

        $resourceUrl = sprintf('%s%s', $this->webPath, $pathInfo);

        $node = $session->getNode($resourceUrl);

        if (!$node) {
        }

        $nodeTypeName = $node->getNodeType()->getName();
        $controllerName = $this->resolver->resolve($nodeTypeName);
    }
}
