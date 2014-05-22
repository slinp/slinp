<?php

namespace spec\Slinp\SlinpBundle\Content;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeLoaderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\SlinpBundle\Content\NodeLoaderFactory');
    }

    function it_should_provide_new_content_loaders_for_yaml()
    {
        $this->createLoader('yaml')->shouldHaveType('Slinp\SlinpBundle\Content\NodeLoaderYaml');
    }
}
