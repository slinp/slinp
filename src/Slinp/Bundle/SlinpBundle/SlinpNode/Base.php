<?php

namespace Slinp\Bundle\SlinpBundle\SlinpNode;

use Slinp\Component\NodeMapper\SlinpNodeInterface;
use PHPCR\NodeInterface;
use Slinp\Component\NodeMapper\ObjectBroker;

class Base implements SlinpNodeInterface
{
    private $phpcrNode;
    private $objectBroker;

    public function __construct(NodeInterface $phpcrNode, ObjectBroker $objectBroker)
    {
        $this->phpcrNode = $phpcrNode;
        $this->objectBroker = $objectBroker;
    }

    /**
     * {@inheritDoc}
     */
    public function _node() 
    {
        return $this->phpcrNode;
    }

    /**
     * {@inheritDoc}
     */
    public function _objectBroker()
    {
        return $this->objectBroker;
    }

    /**
     * Return the children of this node, optionally you
     * can specify a node type filter
     *
     * @return SlinpNodeInterface[]
     */
    public function _children($nodeTypeFilter = null)
    {
        return $this->_objectBroker()->exchangeCollection($this->_node()->getNodes(null, $nodeTypeFilter));
    }

    /**
     * Return the named property value
     *
     * @return mixed
     */
    public function _value($name)
    {
        if ($this->_node()->hasProperty($name)) {
            return $this->getPhpcrNode()->getPropertyValue($name);
        }

        return null;
    }
}
