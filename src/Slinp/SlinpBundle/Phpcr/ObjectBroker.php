<?php

namespace Slinp\SlinpBundle\Phpcr;

use PHPCR\NodeInterface;
use Slinp\SlinpBundle\Phpcr\SlinpObjectInterface;
use Slinp\SlinpBundle\Util\NodeTypeNameTranslator;

class ObjectBroker
{
    protected $nodeTypeNameTranslator;

    public function __construct(NodeTypeNameTranslator $nodeTypeNameTranslator)
    {
        $this->nodeTypeNameTranslator = $nodeTypeNameTranslator;
    }

    public function objectForNode(NodeInterface $node)
    {
        $objectClass = null;
        $nodeType = $node->getPrimaryNodeType();
        $ntNames = $nodeType->getSupertypeNames();
        array_unshift($ntNames, $nodeType->getName());

        $tried = array();

        foreach ($ntNames as $ntName) {
            $objectClass = $this->nodeTypeNameTranslator->toSlinpObject($ntName);
            $tried[] = $objectClass;

            if (class_exists($objectClass)) {
                break;
            }
        }

        if (!class_exists($objectClass)) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find corresponding slinp object class for node type "%s", or any of its super-types (%s). Tried: (%s)',
                $ntName,
                implode(', ', $ntNames),
                implode(', ', array_values($tried))
            ));
        }

        if (!class_exists($objectClass)) {
            throw new \InvalidArgumentException(sprintf(
                'Object class "%s" mapped to node type "%s" does not exist!',
                $objectClass,
                $ntName
            ));
        }

        $object = new $objectClass($node);

        if (!$object instanceof SlinpObjectInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Object class "%s" for node type "%s" exists, but it does not implement the SlinpObjectInterface',
                $objectClass,
                $ntName
            ));
        }

        return $object;
    }
}
