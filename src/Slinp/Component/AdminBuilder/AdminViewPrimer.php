<?php

namespace Slinp\Component\AdminBuilder;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AdminViewPrimer
{
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function primeForNode(AdminViewIntreface $view)
    {
        $this->eventDispatcher->dispatch(AdminViewPrimerEvents::INIT, new AdminViewPrimerEvent($view));
        $this->eventDispatcher->dispatch(AdminViewPrimerEvents::PRIME, new AdminViewPrimerEvent($view));
    }
}
