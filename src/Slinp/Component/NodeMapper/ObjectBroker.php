<?php

namespace Slinp\Component\NodeMapper;

use PHPCR\NodeInterface;
use Slinp\Component\NodeMapper\SlinpNodeInterface;
use Slinp\Bundle\SlinpBundle\Util\NodeTypeNameTranslator;

/**
 * This class will attempt to automatically find a SlinpNode for
 * a given PHPCR node. It does this based on the node type.
 *
 * The node type namespace is translated as the bundle name, and the
 * node type name as the SlinpNode name.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class ObjectBroker
{
    protected $nodeTypeNameTranslator;

    public function __construct(NodeTypeNameTranslator $nodeTypeNameTranslator)
    {
        $this->nodeTypeNameTranslator = $nodeTypeNameTranslator;
    }

    public function exchangeCollection($nodes)
    {
        $ret = array();
        foreach ($nodes as $node) {
            $ret[] = $this->exchange($node);
        }

        return $ret;
    }

    public function exchange(NodeInterface $node)
    {
        $objectClass = null;
        $nodeType = $node->getPrimaryNodeType();
        $ntNames = $nodeType->getSupertypeNames();
        array_unshift($ntNames, $nodeType->getName());

        $tried = array();

        foreach ($ntNames as $ntName) {
            $objectClass = $this->nodeTypeNameTranslator->toSlinpNode($ntName);
            $tried[] = $objectClass;

            if (class_exists($objectClass)) {
                break;
            }
        }

        if (!class_exists($objectClass)) {
            $objectClass = 'Slinp\Bundle\SlinpBundle\SlinpNode\Base';
        }

        if (!class_exists($objectClass)) {
            throw new \InvalidArgumentException(sprintf(
                'Object class "%s" mapped to node type "%s" does not exist!',
                $objectClass,
                $ntName
            ));
        }

        $object = new $objectClass($node, $this);

        if (!$object instanceof SlinpNodeInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Object class "%s" for node type "%s" exists, but it does not implement the SlinpNodeInterface',
                $objectClass,
                $ntName
            ));
        }

        return $object;
    }
}
