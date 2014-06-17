<?php

namespace Slinp\Bundle\SlinpBundle\SlinpNode;

use Slinp\Component\NodeMapper\ObjectBrokerAwareInterface;
use Slinp\Component\NodeMapper\ObjectBroker;

/**
 * Standard Slinp Node Class.
 *
 * Provides convenience methods for traversing and accessing
 * the node hierarchy within the domain model.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Standard extends Base implements ObjectBrokerAwareInterface
{
    private $objectBroker;

    /**
     * {@inheritDoc}
     */
    public function setObjectBroker(ObjectBroker $objectBroker)
    {
        $this->objectBroker = $objectBroker;
    }

    /**
     * Return the object broker
     *
     * @return ObjectBroker
     * @access protected
     */
    protected function objectBroker()
    {
        return $this->objectBroker;
    }

    /**
     * Return the children of this node, optionally you
     * can specify a node type filter
     *
     * @return SlinpNodeInterface[]
     */
    public function children($nodeTypeFilter = null)
    {
        return $this->objectBroker()->exchangeCollection($this->node()->getNodes(null, $nodeTypeFilter));
    }

    /**
     * Return the named property value
     *
     * @return mixed
     */
    public function value($name)
    {
        if ($this->node()->hasProperty($name)) {
            return $this->node()->getPropertyValue($name);
        }

        return null;
    }
}
