<?php

namespace Slinp\SlinpBundle\Routing;

use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use PHPCR\PathNotFoundException;
use PHPCR\Util\PathHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Loader\AnnotationFileLoader;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class SlinpMatcher implements RequestMatcherInterface
{
    protected $registry;
    protected $webPath;
    protected $logger;
    protected $loader;
    protected $kernel;

    public function __construct(
        ManagerRegistry $registry, 
        $webPath, 
        AnnotationFileLoader $loader, 
        KernelInterface $kernel,
        LoggerInterface $logger
    )
    {
        $this->registry = $registry;
        $this->webPath = $webPath;
        $this->loader = $loader;
        $this->logger = $logger;
        $this->kernel = $kernel;
    }

    public function matchRequest(Request $request)
    {
        $session = $this->registry->getConnection();

        $pathInfo = $request->getPathInfo();

        if ($pathInfo == '/') {
            $pathInfo = '';
        }

        $basePath = sprintf('%s/root', $this->webPath);
        $resourceUrl = sprintf('%s%s', $basePath, $pathInfo);
        $nodePath = $resourceUrl;
        $node = null;

        // ======== FIND NODE

        while (!$node) {
            try {
                $node = $session->getNode($nodePath);
                $this->logger->debug('YES: Path found : ' . $nodePath);
            } catch (PathNotFoundException $e) {
                $this->logger->debug('NO: Path not found : ' . $nodePath);
                $nodePath = PathHelper::getParentPath($nodePath);
            }
        }

        $nodeType = $node->getPrimaryNodeType();
        $nodeTypeName = $nodeType->getName();

        if (!in_array('slinp:resource', $nodeType->getSupertypeNames())) {
            throw new RouteNotFoundException(sprintf(
                'Resolved node type "%s" is not a slinp resource.',
                $nodeTypeName
            ));
        }

        // ======== DETERMINE THE CONTROLLER AND LOAD ROUTES

        $bundleName = ucfirst(strstr($nodeTypeName, ':', true));
        $controllerName = ucfirst(substr(strstr($nodeTypeName, ':', false), 1));

        $bundle = $this->kernel->getBundle($bundleName . 'Bundle');

        $controllerClass = sprintf('%s\\Controller\\%sController',
            $bundle->getNamespace(), $controllerName
        );

        $reflection = new \ReflectionClass($controllerClass);
        $controllerFilename = $reflection->getFileName();

        // ======== ADD NODE PREFIX TO ROUTES

        $routes = $this->loader->load($controllerFilename);
        $prefix = substr($node->getPath(), strlen($basePath));
        $routes->addPrefix($prefix);

        foreach ($routes as $route) {
            $route->setPath('/' . trim($route->getPath(), '/'));
        }

        if ($pathInfo == '') {
            $pathInfo = '/';
        }

        // ======== MATCH THE ROUTE

        $requestContext = new RequestContext();
        $requestContext->fromRequest($request);
        $routeMatcher = new UrlMatcher($routes, $requestContext);
        $params = $routeMatcher->match($pathInfo);

        return $params;
    }
}
