<?php

namespace \home\daniel\www\pling\src\Slinp\SlinpBundle\Routing;

use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class SlinpResourceMatcher implements RequestMatcherInterface
{
    protected $registry;
    protected $webPath;

    public function __construct(ManagerRegistry $registry, $webPath)
    {
        $this->registry = $registry;
        $this->webPath = $webPath;
    }

    public function matchRequest(Request $request)
    {
        $session = $this->registry->getConnection();

        $pathInfo = $request->getPathInfo();
        $resourceUrl = sprintf('%s%s', $this->webPath, $pathInfo);

        $node = $session->getNode($resourceUrl);

        if (!$node) {
            throw new RouteNotFoundException(sprintf(
                'Could not find slinp resource "%s"', $resourceUrl
            ));
        }

        $nodeTypeName = $node->getNodeType()->getName();
        $controllerName = $this->nodeTypeToController($nodeTypeName);
    }
}
