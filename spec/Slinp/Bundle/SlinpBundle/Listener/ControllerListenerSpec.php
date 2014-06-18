<?php

namespace spec\Slinp\Bundle\SlinpBundle\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slinp\Component\NodeMapper\ObjectBroker;
use PHPCR\NodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Slinp\Component\NodeMapper\SlinpNodeInterface;

class ControllerListenerSpec extends ObjectBehavior
{
    public function let(
        ObjectBroker $objectBroker
    )
    {
        $this->beConstructedWith($objectBroker);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Slinp\Bundle\SlinpBundle\Listener\ControllerListener');
    }

    function it_should_add_a_resource_parameter_to_the_request_when_a_node_parameter_is_present(
        NodeInterface $node,
        ObjectBroker $objectBroker,
        FilterControllerEvent $event,
        SlinpNodeInterface $resource
    )
    {
        $request = Request::create('/');
        $request->attributes->set('node', $node->getWrappedObject());
        $objectBroker->exchange($node->getWrappedObject())->willReturn($resource);
        $event->getRequest()->willReturn($request);
        $this->onKernelController($event);
        $resource = $request->attributes->get('resource');
    }
}
