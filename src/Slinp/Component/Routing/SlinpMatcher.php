<?php

namespace Slinp\Component\Routing;

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
use Slinp\Bundle\SlinpBundle\Util\NodeTypeNameTranslator;
use PHPCR\SessionInterface;

/**
 * Incoming request matcher
 *
 * This matcher first looks for a node in the content repository,
 * then infers a ControllerName from the node:type, e.g.
 *
 *     slinp:article => Slinp\SlinpBundle\Controller\ArticleController
 *
 * The controller is then parsed for @Route annotations and the URL is
 * matched and routed to one of the controllers methods.
 *
 * @todo Refactor this into separate classes.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class SlinpMatcher implements RequestMatcherInterface
{
    protected $phpcrSession;
    protected $webPath;
    protected $logger;
    protected $loader;
    protected $nodeTypeNameTranslator;

    public function __construct(
        SessionInterface $phpcrSession, 
        $webPath, 
        AnnotationFileLoader $loader, 
        NodeTypeNameTranslator $nodeTypeNameTranslator,
        LoggerInterface $logger
    )
    {
        $this->phpcrSession = $phpcrSession;
        $this->webPath = $webPath;
        $this->loader = $loader;
        $this->logger = $logger;
        $this->nodeTypeNameTranslator = $nodeTypeNameTranslator;
    }

    public function matchRequest(Request $request)
    {
        $session = $this->phpcrSession;

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

        $controllerFilename = $this->nodeTypeNameTranslator->toControllerPath($nodeTypeName);

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
        $params['node'] = $node;

        return $params;
    }
}
