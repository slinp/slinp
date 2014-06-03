<?php

namespace spec\Slinp\Bundle\SlinpBundle\Util;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Component\NodeMapper\SlinpSession;
use Slinp\Component\NodeMapper\SlinpNodeInterface;

class SlinpContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Bundle\SlinpBundle\Util\SlinpContext');
    }

    function let(
        SlinpSession $session
    )
    {
        $this->beConstructedWith($session, '/foo/bar');
    }

    function it_returns_the_web_root_node(
        SlinpSession $session,
        SlinpNodeInterface $slinpObject
    )
    {
        $session->getNode('/foo/bar/root')->willReturn($slinpObject);
        $this->getWebRootNode()->shouldReturn($slinpObject);
    }
}
