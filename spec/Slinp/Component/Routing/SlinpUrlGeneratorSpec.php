<?php

namespace spec\Slinp\Component\Routing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Bundle\SlinpBundle\SlinpNode\Resource;
use PHPCR\NodeInterface;

class SlinpUrlGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\Routing\SlinpUrlGenerator');
    }

    function let()
    {
        $this->beConstructedWith('/web');
    }

    function it_should_generate_a_web_path_for_a_resource(
        Resource $resource,
        NodeInterface $node
    )
    {
        $resource->node()->willReturn($node);
        $node->getPath()->willReturn('/web/root/foobar/barfoo');

        $this->generate($resource)->shouldReturn('/foobar/barfoo');
    }
}
