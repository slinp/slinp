<?php

namespace spec\Slinp\Component\NodeMapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\NodeInterface;
use PHPCR\NodeType\NodeTypeInterface;
use Slinp\Bundle\SlinpBundle\Util\NodeTypeNameTranslator;

class ObjectBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\NodeMapper\ObjectBroker');
    }

    function let(
        NodeTypeNameTranslator $nodeTypeNameTranslator
    )
    {
        $this->beConstructedWith(
            $nodeTypeNameTranslator
        );
    }

    function it_will_throw_an_exception_if_the_class_does_not_exist(
        NodeInterface $node,
        NodeTypeInterface $nodeType,
        NodeTypeNameTranslator $nodeTypeNameTranslator
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array());
        $nodeType->getName()->willReturn('nt:barbar');
        $node->getPrimaryNodeType()->willReturn($nodeType);
        $nodeTypeNameTranslator->toSlinpNode('nt:barbar')->willReturn('Foo\\Bar\\SomeObject');

        $this->shouldThrow(new \InvalidArgumentException(
            'Could not find corresponding slinp object class for node type "nt:barbar", or any of its super-types (nt:barbar). Tried: (Foo\Bar\SomeObject)'
        ))->duringExchange($node);
    }

    function it_will_throw_an_exception_if_the_inferred_object_does_not_implement_the_interface(
        NodeInterface $node,
        NodeTypeInterface $nodeType,
        NodeTypeNameTranslator $nodeTypeNameTranslator
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array());
        $nodeType->getName()->willReturn('slinpTest:meDoesNotImplementTheInterface');
        $nodeTypeNameTranslator->toSlinpNode('slinpTest:meDoesNotImplementTheInterface')->willReturn('Slinp\Bundle\SlinpTestBundle\SlinpNode\MeDoesNotImplementTheInterface');

        $node->getPrimaryNodeType()->willReturn($nodeType);

        $this->shouldThrow(new \InvalidArgumentException(
            'Object class "Slinp\Bundle\SlinpTestBundle\SlinpNode\MeDoesNotImplementTheInterface" for node type "slinpTest:meDoesNotImplementTheInterface" exists, but it does not implement the SlinpNodeInterface'
        ))->duringExchange($node);
    }

    function it_will_return_an_object_for_a_valid_mapped_node_type(
        NodeInterface $node,
        NodeTypeInterface $nodeType,
        NodeTypeNameTranslator $nodeTypeNameTranslator
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array('nt:resource'));
        $nodeType->getName()->willReturn('nt:article');
        $node->getPrimaryNodeType()->willReturn($nodeType);
        $nodeTypeNameTranslator->toSlinpNode('nt:article')->willReturn('Slinp\Bundle\SlinpTestBundle\SlinpNode\Article');
        $this->exchange($node)->shouldReturnAnInstanceOf('Slinp\Bundle\SlinpTestBundle\SlinpNode\Article');
    }
}
