<?php

namespace Slinp\Component\AdminBuilder\View;

use Slinp\Component\AdminBuilder\WidgetInterface;

class WidgetCollection
{
    protected $widgets;

    public function append($id, WidgetInterface $widget)
    {
        $this->widgets[$id] = $widget;
    }

    public function place($id)
    {
        return new Placement($this, $id);
    }

    public function getMany(array $ids)
    {
        $widgets = array();

        foreach ($ids as $id) {
            $widget = $this->get($id);
            if (null !== $widget) {
                $widgets[] = $widget;
            }
        }

        return $widgets;
    }

    public function get($id)
    {
        if (isset($this->widgets[$id])) {
            return $this->widgets[$id];
        }

        return null;
    }
}
