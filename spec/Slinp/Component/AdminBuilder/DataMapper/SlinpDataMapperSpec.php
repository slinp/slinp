<?php

namespace spec\Slinp\Component\AdminBuilder\DataMapper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlinpDataMapperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\AdminBuilder\DataMapper\SlinpDataMapper');
    }
}
