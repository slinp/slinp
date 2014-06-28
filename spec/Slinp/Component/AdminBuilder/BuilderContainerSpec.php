<?php

namespace spec\Slinp\Component\AdminBuilder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Component\AdminBuilder\NodeTypeBuilderInterface;

class BuilderContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\AdminBuilder\BuilderContainer');
    }

    function it_should_be_able_to_register_node_type_builders(
        NodeTypeBuilderInterface $ntBuilder
    ) {
        $ntBuilder->getTarget()->willReturn('nt:foobar');
        $this->registerBuilder($ntBuilder);
        $this->getBuilderFor('nt:foobar')->shouldReturn($ntBuilder);
    }
}
