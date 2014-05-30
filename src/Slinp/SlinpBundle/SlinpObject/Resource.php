<?php

namespace Slinp\SlinpBundle\SlinpObject;

use Slinp\SlinpBundle\Phpcr\SlinpObjectInterface;
use PHPCR\NodeInterface;

class Resource implements SlinpObjectInterface
{
    protected $phpcrNode;

    public function __construct(NodeInterface $phpcrNode)
    {
        $this->phpcrNode = $phpcrNode;
    }

    public function getPhpcrNode() 
    {
        return $this->phpcrNode;
    }

    public function get($property)
    {
        return $this->getPhpcrNode()->getPropertyValue($property);
    }
}
