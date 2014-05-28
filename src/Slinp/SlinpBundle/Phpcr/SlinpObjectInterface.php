<?php

namespace Slinp\SlinpBundle\Phpcr;

use PHPCR\NodeInterface;

interface SlinpObjectInterface
{
    public function __construct(NodeInterface $node);
}
