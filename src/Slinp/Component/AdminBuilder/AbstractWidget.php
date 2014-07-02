<?php

namespace Slinp\Component\AdminBuilder;

abstract class AbstractWidget implements WidgetInterface
{
    protected $parent;

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(WidgetInterface $widget)
    {
        $this->parent = $widget;
    }
}
