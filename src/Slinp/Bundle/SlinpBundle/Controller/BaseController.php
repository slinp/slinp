<?php

namespace Slinp\Bundle\SlinpBundle\Controller;

use Slinp\Bundle\SlinpBundle\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Slinp\Component\NodeMapper\SlinpNodeInterface;

class BaseController extends Controller
{
    /**
     * @Route("/")
     */
    public function defaultAction(SlinpNodeInterface $resource)
    {
        $nodeNameTranslator = $this->get('slinp.util.node_type_name_translator');
        $nodeType = $resource->node()->getPrimaryNodeType();

        $types = array_merge(
            array($nodeType->getName()),
            $nodeType->getSupertypeNames()
        );

        $typeMap = array();

        foreach ($types as $type) {
            $typeMap[$type] = array(
                'bundle' => $nodeNameTranslator->toBundleName($type),
                'controller' => $nodeNameTranslator->toControllerName($type),
            );
        }

        return $this->render('SlinpBundle:Base:default.html.twig', array(
            'resource' => $resource,
            'typeMap' => $typeMap,
        ), new Response(null, 404));
    }
}
