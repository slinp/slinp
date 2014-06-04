<?php

namespace Slinp\Bundle\SlinpBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Slinp\Component\NodeMapper\ObjectBroker;

class ControllerListener
{
    protected $objectBroker;

    public function __construct(ObjectBroker $objectBroker)
    {
        $this->objectBroker = $objectBroker;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        if ($request->attributes->has('node')) {
            $node = $request->attributes->get('node');
            $resource = $this->objectBroker->exchange($node);
            $request->attributes->set('resource', $resource);
        }
    }
}
