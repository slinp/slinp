<?php

namespace spec\Slinp\Component\AdminBuilder\View;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Component\AdminBuilder\View\WidgetCollection;
use Slinp\Component\AdminBuilder\WidgetContainerInterface;
use Slinp\Component\AdminBuilder\WidgetInterface;

class PlacementSpec extends ObjectBehavior
{
    function let(
        WidgetCollection $widgetCollection
    )
    {
        $this->beConstructedWith($widgetCollection, 'widget_1');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Component\AdminBuilder\View\Placement');
    }

    function it_can_place_a_source_widget_inside_a_target_widget(
        WidgetInterface $widget,
        WidgetContainerInterface $container,
        WidgetCollection $widgetCollection
    )

    {
        $widgetCollection->getMany(array('widget_1'))->willReturn(array($widget));
        $widgetCollection->get('widget_2')->willReturn($container);

        $this->inside('widget_2');
        $container->append($widget)->shouldBeCalled();
    }

    function is_can_place_a_source_widget_before_a_target_widget(
        WidgetInterface $widget1,
        WidgetInterface $widget2,
        WidgetInterface $widget3,
        WidgetContainerInterface $container,
        WidgetCollection $widgetCollection
    )
    {
        $widgetCollection->get('widget_3')->willReturn($widget3);
        $widget3->getParent()->willReturn($container);
        $container->getChildren()->willReturn(array(
            $widget1, $widget2, $widget3
        ));

        $this->before('widget_3');
    }

    function it_will_throw_an_exception_if_target_is_not_a_container(
        WidgetCollection $widgetCollection,
        WidgetInterface $widget1,
        WidgetInterface $widget2
    )
    {
        $widgetCollection->getMany(array('widget_1'))->willReturn(array($widget1));
        $widgetCollection->get('widget_2')->willReturn($widget2);
        $this->shouldThrow('\InvalidArgumentException')->duringInside('widget_2');
    }
}
