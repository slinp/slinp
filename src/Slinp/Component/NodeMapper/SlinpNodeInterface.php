<?php

namespace Slinp\Component\NodeMapper;

use PHPCR\NodeInterface;
use Slinp\SlinpBundle\Phpcr\PHPCR;

interface SlinpNodeInterface
{
    public function __construct(NodeInterface $node);

    /**
     * Return the underlying PHPCR node
     *
     * @return PHPCR\NodeInterface
     */
    public function getPhpcrNode();
}
