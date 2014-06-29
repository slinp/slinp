<?php

namespace Slinp\Component\NodeMapper;

use PHPCR\NodeInterface;
use Slinp\SlinpBundle\Phpcr\PHPCR;
use Slinp\Component\NodeMapper\ObjectBroker;

/**
 * PHPCR Node Wrapper used by Slinp domain objects.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface SlinpNodeInterface extends NodeInterface, \IteratorAggregate
{
    /**
     * The contructor is passed the PHPCR Node which class instances implementing
     * this interface will wrap. The object broker must also be provided, enabling
     * class instances to instantiate new wrapped nodes.
     *
     * @param NodeInterface $node
     * @param ObjectBroker $objectBroker
     */
    public function __construct(NodeInterface $node);

    /**
     * Return the underlying PHPCR node
     *
     * @return PHPCR\NodeInterface
     */
    public function getPhpcrNode();
}
