<?php

namespace Slinp\Component\NodeMapper;

use PHPCR\NodeInterface;
use Slinp\Component\NodeMapper\SlinpNodeInterface;
use Slinp\Bundle\SlinpBundle\Util\NodeTypeNameTranslator;
use Slinp\Component\NodeMapper\ObjectBrokerAwareInterface;

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
    protected $defaultNodeClass;

    public function __construct(
        NodeTypeNameTranslator $nodeTypeNameTranslator,
        $defaultNodeClass
    )
    {
        $this->nodeTypeNameTranslator = $nodeTypeNameTranslator;
        $this->defaultNodeClass = $defaultNodeClass;
    }

    /**
     * Will exchange an array of PHPCR nodes for an array of Slinp nodes
     *
     * @param array $nodes
     *
     * @return SlinpNodeInterface[]
     */
    public function exchangeCollection($nodes)
    {
        $ret = array();
        foreach ($nodes as $node) {
            $ret[] = $this->exchange($node);
        }

        return $ret;
    }

    /**
     * Exchange a PHPCR Node for a Slinp Node
     * 
     * @param NodeInterface $node
     *
     * @return SlinpNodeInterface
     */
    public function exchange(NodeInterface $node)
    {
        $nodeClass = null;
        $nodeType = $node->getPrimaryNodeType();
        $ntNames = $nodeType->getSupertypeNames();
        array_unshift($ntNames, $nodeType->getName());

        $tried = array();

        foreach ($ntNames as $ntName) {
            $nodeClass = $this->nodeTypeNameTranslator->toSlinpNode($ntName);
            $tried[] = $nodeClass;

            if (class_exists($nodeClass)) {
                break;
            }
        }

        if (!class_exists($nodeClass) && $this->defaultNodeClass) {
            $nodeClass = $this->defaultNodeClass;
        }

        if (!class_exists($nodeClass)) {
            throw new \InvalidArgumentException(sprintf(
                'Object class "%s" mapped to node type "%s" does not exist!',
                $nodeClass,
                $ntName
            ));
        }

        $object = new $nodeClass($node, $this);

        if ($object instanceof ObjectBrokerAwareInterface) {
            $object->setObjectBroker($this);
        }

        if (!$object instanceof SlinpNodeInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Object class "%s" for node type "%s" exists, but it does not implement the SlinpNodeInterface',
                $nodeClass,
                $ntName
            ));
        }

        return $object;
    }
}
