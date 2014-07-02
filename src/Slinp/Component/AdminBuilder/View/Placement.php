<?php

namespace Slinp\Component\AdminBuilder\View;

use Slinp\Component\AdminBuilder\WidgetContainerInterface;

class Placement
{
    const LAST_CHILD = 'last-child';
    const NEXT_SIBLING = 'next-sibling';
    const PREV_SIBLING = 'prev-sibling';

    protected $widgetCollection;
    protected $type;
    protected $targetIds;

    public function __construct(WidgetCollection $widgetCollection, $targetIds)
    {
        $this->targetIds = (array) $targetIds;
        $this->widgetCollection = $widgetCollection;
    }

    public function inside($targetId)
    {
        $targetWidget = $this->widgetCollection->get($targetId);
        $sourceWidgets = $this->widgetCollection->getMany($this->targetIds);

        if (!$targetWidget instanceof WidgetContainerInterface) {
            throw new \InvalidArgumentException(sprintf(
                'You cannot add widgets to widget of type "%s". Container widgets must ' . 
                'implement the interface WidgetContainerInterface'
            , get_class($targetWidget)));
        }

        foreach ($sourceWidgets as $sourceWidget) {
            $targetWidget->append($sourceWidget);
        }
    }
}
