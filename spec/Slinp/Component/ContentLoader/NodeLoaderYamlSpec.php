<?php

namespace spec\Slinp\Component\ContentLoader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\NodeInterface;

class NodeLoaderYamlSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\ContentLoader\NodeLoaderYaml');
    }

    function it_should_load_the_given_node_with_data_from_yaml_file(
        NodeInterface $node
    )
    {
        $fixture = __DIR__ . '/fixtures/node.yml';

        $res = $this->load($fixture)->shouldReturn(array(
            'property1' => 'barfoo',
        ));
    }
}
