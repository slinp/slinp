<?php

namespace Slinp\Component\AdminBuilder\Widget;

use Slinp\Component\AdminBuilder\WidgetContainerInterface;
use Slinp\Component\AdminBuilder\WidgetInterface;
use Slinp\Component\AdminBuilder\AbstractWidget;

class LayoutWidget implements WidgetContainerInterface
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
        return 'layout_widget';
    }

    public function setParent(WidgetInterface $widget)
    {
        throw new \BadMethodCallException(
            'Cannot call setParent on LayoutWidget -- layouts do not have parents!'
        );
    }

    public function getParent()
    {
        return null;
    }
}
