<?php

namespace spec\Slinp\SlinpBundle\Content;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\SessionInterface;

class ContentLoaderSpec extends ObjectBehavior
{
    function let(
        SessionInterface $session
    )
    {
        $this->beConstructedWith($session, '/test/app/content', '/web');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Content\ContentLoader');
    }

    function it_loads_node_data_from_a_folder_hierarchy()
    {
    }
}
