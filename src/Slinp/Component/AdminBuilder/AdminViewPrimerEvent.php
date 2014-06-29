<?php

namespace Slinp\Component\AdminBuilder;

use Symfony\Component\EventDispatcher\Event;

class AdminViewPrimerEvent extends Event
{
    protected $view;

    public function __construct(AdminViewIntreface $view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }
}
