<?php

namespace spec\Slinp\Component\AdminBuilder\View;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Component\AdminBuilder\WidgetInterface;
use Slinp\Component\AdminBuilder\WidgetContainerInterface;

class WidgetCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\AdminBuilder\View\WidgetCollection');
    }

    function it_can_have_widgets_added_to_it(
        WidgetInterface $widget1,
        WidgetInterface $widget2
    )
    {
        $this->append('widget_1', $widget1);
        $this->append('widget_2', $widget2);

        $this->get('widget_1')->shouldReturn($widget1);
        $this->get('widget_2')->shouldReturn($widget2);
    }

    function it_can_place_nodes(
        WidgetInterface $widget,
        WidgetContainerInterface $widgetContainer
    )
    {
        $this->append('widget_1', $widget);
        $this->append('widget_2', $widgetContainer);

        $this->place('widget_1')->inside('widget_2');
        $widgetContainer->append($widget)->shouldBeCalled();
    }
}
