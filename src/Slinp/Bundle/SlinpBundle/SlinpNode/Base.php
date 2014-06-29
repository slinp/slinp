<?php

namespace Slinp\Bundle\SlinpBundle\SlinpNode;

use Slinp\Component\NodeMapper\SlinpNodeInterface;
use PHPCR\NodeInterface;
use Slinp\Component\NodeMapper\ObjectBroker;
use Slinp\Component\NodeMapper\ObjectBrokerAwareInterface;
use Slinp\Component\NodeMapper\PhpcrNodeTrait;

/**
 * Most minimal implementation of the SlinpNodeInterface
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Base implements SlinpNodeInterface, ObjectBrokerAwareInterface
{
    use PhpcrNodeTrait;

    private $phpcrNode;
    private $objectBroker;

    /**
     * {@inheritDoc}
     */
    public function __construct(NodeInterface $phpcrNode)
    {
        $this->phpcrNode = $phpcrNode;
    }

    public function getPhpcrNode()
    {
        return $this->phpcrNode;
    }

    public function getIterator()
    {
        return $this->getNodes();
    }

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

}
