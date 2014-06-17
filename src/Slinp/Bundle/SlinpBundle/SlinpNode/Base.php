<?php

namespace Slinp\Bundle\SlinpBundle\SlinpNode;

use Slinp\Component\NodeMapper\SlinpNodeInterface;
use PHPCR\NodeInterface;
use Slinp\Component\NodeMapper\ObjectBroker;
use Slinp\Component\NodeMapper\ObjectBrokerAwareInterface;

/**
 * Most minimal implementation of the SlinpNodeInterface
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Base implements SlinpNodeInterface
{
    private $phpcrNode;

    /**
     * {@inheritDoc}
     */
    public function __construct(NodeInterface $phpcrNode)
    {
        $this->phpcrNode = $phpcrNode;
    }

    /**
     * {@inheritDoc}
     */
    public function node() 
    {
        return $this->phpcrNode;
    }
}
