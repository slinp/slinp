<?php

namespace Slinp\Component\AdminBuilder;

interface WidgetContainerInterface extends WidgetInterface
{
    /**
     * Return the children of this container
     */
    public function getChildren();

    /**
     * Append a child widget to this container
     */
    public function append(WidgetInterface $widget);
}
