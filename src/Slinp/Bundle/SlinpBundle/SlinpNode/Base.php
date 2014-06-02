<?php

namespace Slinp\Bundle\SlinpBundle\SlinpNode;

use Slinp\Component\NodeMapper\SlinpNodeInterface;
use PHPCR\NodeInterface;

class Base implements SlinpNodeInterface
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

    /**
     * @see NodeInterface::getNodes
     */
    public function getNodes()
    {
        $nodes = array();
        $thisClass = get_class($this);
        foreach ($this->phpcrNode->getNodes() as $child) {
            $nodes[] = new $thisClass($child);
        }

        return $nodes;
    }

    /**
     * @see NodeInterface::getName
     */
    public function getName()
    {
        return $this->phpcrNode->getName();
    }

    /**
     * @see NodeInterface::getPath
     */
    public function getPath()
    {
        return $this->phpcrNode->getPath();
    }
}
