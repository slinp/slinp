<?php

namespace Slinp\Component\AdminBuilder\Widget;

use Slinp\Component\AdminBuilder\WidgetInterface;
use Slinp\Component\AdminBuilder\AbstractWidget;

/**
 * Plain text widget
 */
class TextWidget extends AbstractWidget implements WidgetInterface
{
    protected $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getWidgetType()
    {
        return 'text_widget';
    }

    public function getText()
    {
        return $this->text;
    }
}
