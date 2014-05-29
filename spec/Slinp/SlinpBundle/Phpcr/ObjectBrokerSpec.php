<?php

namespace spec\Slinp\SlinpBundle\Phpcr;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\NodeInterface;
use PHPCR\NodeType\NodeTypeInterface;

class ObjectBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Phpcr\ObjectBroker');
    }

    function let()
    {
        $this->beConstructedWith(array(
            'nt:article' => 'Slinp\SlinpTestBundle\SlinpObject\Article',
            'nt:notexist' => 'Slinp\SlinpTestBundle\SlinpObject\NotExist',
            'nt:nointerface' => 'Slinp\SlinpTestBundle\SlinpObject\MeDoesNotImplementTheInterface',
        ));
    }

    function it_will_throw_an_exception_for_an_unmapped_node_type(
        NodeInterface $node,
        NodeTypeInterface $nodeType
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array());
        $nodeType->getName()->willReturn('nt:barbar');
        $node->getPrimaryNodeType()->willReturn($nodeType);
        try {
            $this->objectForNode($node);
        } catch (\InvalidArgumentException $e) {
        }
    }

    function it_will_throw_an_exception_if_mapped_object_class_does_not_exist(
        NodeInterface $node,
        NodeTypeInterface $nodeType
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array('nt:notexist'));
        $nodeType->getName()->willReturn('nt:barbar');
        $node->getPrimaryNodeType()->willReturn($nodeType);
        try {
            $this->objectForNode($node);
        } catch (\InvalidArgumentException $e) {
        }
    }

    function it_will_throw_an_exception_if_the_mapped_object_does_not_implement_the_interface(
        NodeInterface $node,
        NodeTypeInterface $nodeType
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array('nt:nointerface'));
        $nodeType->getName()->willReturn('nt:barbar');
        $node->getPrimaryNodeType()->willReturn($nodeType);
        try {
            $this->objectForNode($node);
        } catch (\InvalidArgumentException $e) {
        }
    }

    function it_will_return_an_object_for_a_valid_mapped_node_type(
        NodeInterface $node,
        NodeTypeInterface $nodeType
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array('nt:resource'));
        $nodeType->getName()->willReturn('nt:article');
        $node->getPrimaryNodeType()->willReturn($nodeType);
        $this->objectForNode($node)->shouldReturnAnInstanceOf('Slinp\SlinpTestBundle\SlinpObject\Article');
    }

}
