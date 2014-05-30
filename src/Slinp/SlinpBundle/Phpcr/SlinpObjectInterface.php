<?php

namespace Slinp\SlinpBundle\Phpcr;

use PHPCR\NodeInterface;

interface SlinpObjectInterface
{
    public function __construct(NodeInterface $node);

    /**
     * Return the underlying PHPCR node
     *
     * @return PHPCR\NodeInterface
     */
    public function getPhpcrNode();
}
