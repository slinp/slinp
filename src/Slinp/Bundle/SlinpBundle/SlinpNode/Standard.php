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
class Standard extends Base
{
    /**
     * Return the named property value
     *
     * Shortcut for getPropertyValue but also checks that the property exists
     * and returns null rather than throwing an exception.
     *
     * @return mixed
     */
    public function getValue($name)
    {
        if ($this->hasProperty($name)) {
            return $this->getPropertyValue($name);
        }

        return null;
    }
}
