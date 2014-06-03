<?php

namespace spec\Slinp\Component\ContentLoader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeLoaderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\ContentLoader\NodeLoaderFactory');
    }

    function it_should_provide_new_content_loaders_for_yaml()
    {
        $this->createLoader('yaml')->shouldHaveType('Slinp\Component\ContentLoader\NodeLoaderYaml');
    }
}
