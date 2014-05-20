<?php

namespace Slinp\SlinpBundle\Routing;

use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use PHPCR\PathNotFoundException;
use PHPCR\Util\PathHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class SlinpResourceMatcher implements RequestMatcherInterface
{
    protected $registry;
    protected $webPath;
    protected $logger;

    public function __construct(ManagerRegistry $registry, $webPath, LoggerInterface $logger)
    {
        $this->registry = $registry;
        $this->webPath = $webPath;
        $this->logger = $logger;
    }

    public function matchRequest(Request $request)
    {
        $session = $this->registry->getConnection();

        $pathInfo = $request->getPathInfo();

        if ($pathInfo == '/') {
            $pathInfo = '';
        }

        $resourceUrl = sprintf('%s/root%s', $this->webPath, $pathInfo);
        $nodePath = $resourceUrl;
        $node = null;

        while (!$node) {
            try {
                $node = $session->getNode($nodePath);
                $this->logger->debug('YES: Path found : ' . $nodePath);
            } catch (PathNotFoundException $e) {
                $this->logger->debug('NO: Path not found : ' . $nodePath);
                $nodePath = PathHelper::getParentPath($nodePath);
            }
        }

        if (!$node) {
            throw new RouteNotFoundException(sprintf(
                'Could not find slinp resource node for path "%s"',
                $nodePath
            ));
        }

        $nodeType = $node->getPrimaryNodeType();
        $nodeTypeName = $nodeType->getName();

        if (!in_array('slinp:resource', $nodeType->getSupertypeNames())) {
            throw new RouteNotFoundException(sprintf(
                'Resolved node type "%s" is not a slinp resource.',
                $nodeTypeName
            ));
        }

        $namespace = strstr($nodeTypeName, ':', true);
        $controllerName = substr(strstr($nodeTypeName, ':', false), 1);

        $controllerResource = sprintf('%sBundle:%s:default',
            ucfirst($namespace),
            ucfirst($controllerName)
        );

        return array(
            '_controller' => $controllerResource
        );
    }
}
