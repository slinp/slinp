<?php

namespace Slinp\SlinpTestBundle\SlinpObject;

use PHPCR\NodeInterface;
use Slinp\SlinpBundle\Phpcr\SlinpObjectInterface;

class Article implements SlinpObjectInterface
{
    public function __construct(NodeInterface $node)
    {
    }
}
