<?php

namespace Slinp\Component\NodeMapper;

/**
 * The ObjectBroker will automatically inject an instance of itself
 * into user nodes implementing this interface.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface ObjectBrokerAwareInterface
{
    /**
     * Set the object broker instance.
     *
     * @param ObjectBroker $objectBroker
     */
    public function setObjectBroker(ObjectBroker $objectBroker);
}
