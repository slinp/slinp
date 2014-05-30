<?php

namespace spec\Slinp\SlinpBundle\Phpcr;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\NodeInterface;
use PHPCR\NodeType\NodeTypeInterface;
use Slinp\SlinpBundle\Util\NodeTypeNameTranslator;

class ObjectBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Phpcr\ObjectBroker');
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
        $nodeTypeNameTranslator->toSlinpObject('nt:barbar')->willReturn('Foo\\Bar\\SomeObject');

        $this->shouldThrow(new \InvalidArgumentException(
            'Could not find corresponding slinp object class for node type "nt:barbar", or any of its super-types (nt:barbar). Tried: (Foo\Bar\SomeObject)'
        ))->duringObjectForNode($node);
    }

    function it_will_throw_an_exception_if_the_inferred_object_does_not_implement_the_interface(
        NodeInterface $node,
        NodeTypeInterface $nodeType,
        NodeTypeNameTranslator $nodeTypeNameTranslator
    )
    {
        $nodeType->getSupertypeNames()->willReturn(array());
        $nodeType->getName()->willReturn('slinpTest:meDoesNotImplementTheInterface');
        $nodeTypeNameTranslator->toSlinpObject('slinpTest:meDoesNotImplementTheInterface')->willReturn('Slinp\SlinpTestBundle\SlinpObject\MeDoesNotImplementTheInterface');

        $node->getPrimaryNodeType()->willReturn($nodeType);

        $this->shouldThrow(new \InvalidArgumentException(
            'Object class "Slinp\SlinpTestBundle\SlinpObject\MeDoesNotImplementTheInterface" for node type "slinpTest:meDoesNotImplementTheInterface" exists, but it does not implement the SlinpObjectInterface'
        ))->duringObjectForNode($node);
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
        $nodeTypeNameTranslator->toSlinpObject('nt:article')->willReturn('Slinp\SlinpTestBundle\SlinpObject\Article');
        $this->objectForNode($node)->shouldReturnAnInstanceOf('Slinp\SlinpTestBundle\SlinpObject\Article');
    }
}