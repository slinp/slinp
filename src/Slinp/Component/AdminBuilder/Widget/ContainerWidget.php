<?php

namespace Slinp\Component\AdminBuilder\Widget;

use Slinp\Component\AdminBuilder\WidgetContainerInterface;
use Slinp\Component\AdminBuilder\WidgetInterface;
use Slinp\Component\AdminBuilder\AbstractWidget;

class ContainerWidget extends AbstractWidget implements WidgetContainerInterface
{
    protected $children;

    public function append(WidgetInterface $widget)
    {
        $this->children[] = $widget;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getWidgetType()
    {
        return 'container_widget';
    }
}
