<?php

namespace spec\Slinp\SlinpBundle\Util;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\SlinpBundle\Phpcr\SlinpSession;
use Slinp\SlinpBundle\Phpcr\SlinpObjectInterface;

class SlinpContextSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Util\SlinpContext');
    }

    function let(
        SlinpSession $session
    )
    {
        $this->beConstructedWith($session, '/foo/bar');
    }

    function it_returns_the_web_root_node(
        SlinpSession $session,
        SlinpObjectInterface $slinpObject
    )
    {
        $session->getNode('/foo/bar/root')->willReturn($slinpObject);
        $this->getWebRootNode()->shouldReturn($slinpObject);
    }
}
