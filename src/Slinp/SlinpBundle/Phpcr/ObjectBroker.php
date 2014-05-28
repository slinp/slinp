<?php

namespace Slinp\SlinpBundle\Phpcr;

use PHPCR\NodeInterface;
use Slinp\SlinpBundle\Phpcr\SlinpObjectInterface;

class ObjectBroker
{
    protected $ntObjectMap;

    public function __construct(array $ntObjectMap = array())
    {
        $this->ntObjectMap = $ntObjectMap;
    }

    public function objectForNode(NodeInterface $node)
    {
        $nodeType = $node->getPrimaryNodeType();
        $ntNames = $nodeType->getSupertypeNames();
        array_unshift($ntNames, $nodeType->getName());

        foreach ($ntNames as $ntName) {
            if (isset($this->ntObjectMap[$ntName])) {
                $objectClass = $this->ntObjectMap[$ntName];
                break;
            }
        }

        if (!$objectClass) {
            throw new \InvalidArgumentException(sprintf(
                'There is no object mapping for node type "%s", or any of its super-types (%s) the following node types are mapped: %s',
                $ntName,
                implode(', ', array_keys($node->getSupertypeNames())),
                implode(', ', array_keys($this->ntObjectMap))
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
                'Object class "%s" is mapped to node type "%s", but it does not implement the SlinpObjectInterface',
                $objectClass,
                $ntName
            ));
        }

        return $object;
    }
}
