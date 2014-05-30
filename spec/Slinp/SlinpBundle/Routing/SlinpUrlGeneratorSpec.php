<?php

namespace spec\Slinp\SlinpBundle\Routing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\SlinpBundle\SlinpObject\Resource;

class SlinpUrlGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Routing\SlinpUrlGenerator');
    }

    function let()
    {
        $this->beConstructedWith('/web');
    }

    function it_should_generate_a_web_path_for_a_resource(
        Resource $resource
    )
    {
        $resource->getPath()->willReturn('/web/root/foobar/barfoo');
        $this->generate($resource)->shouldReturn('/foobar/barfoo');
    }
}
