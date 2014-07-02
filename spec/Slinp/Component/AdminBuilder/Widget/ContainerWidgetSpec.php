<?php

namespace spec\Slinp\Component\AdminBuilder\Widget;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Component\AdminBuilder\WidgetInterface;

class ContainerWidgetSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\AdminBuilder\Widget\ContainerWidget');
    }

    function it_can_have_widgets_added_to_it(
        WidgetInterface $widget1,
        WidgetInterface $widget2
    )
    {
        $this->append($widget1);
        $this->append($widget2);

        $this->getChildren()->shouldReturn(array(
            $widget1, $widget2
        ));
    }
}
