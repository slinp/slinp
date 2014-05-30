<?php

namespace Slinp\SlinpBundle\SlinpObject;

class SlinpResource implements SlinpObjectInterface
{
    protected $node;

    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    public function getNode() 
    {
        return $this->node;
    }
}
