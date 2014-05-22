<?php

namespace Slinp\SlinpBundle\Content;

use PHPCR\NodeInterface;

interface NodeLoader
{
    public function load(NodeInterface $node, $resource);
}
