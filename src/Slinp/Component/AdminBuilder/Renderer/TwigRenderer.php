<?php

namespace Slinp\Component\AdminBuilder\Renderer;

use Slinp\Component\AdminBuilder\WidgetInterface;

class TwigRenderer
{
    protected $twig;
    protected $templateResource;

    public function __construct(\Twig_Environment $twig, $templateResource)
    {
        $this->twig = $twig;
        $this->templateResource = $templateResource;
    }

    public function render(WidgetInterface $widget)
    {
        $blockName = $widget->getWidgetType();
        $template = $this->twig->loadTemplate($this->templateResource);

        if (!$template->hasBlock($blockName)) {
            throw new \InvalidArgumentException(sprintf(
                'Cannot find block named "%s" when rendering admin template "%s"',
                $blockName, $this->templateResource
            ));
        }
        $html = $template->renderBlock($blockName, array('widget' => $widget, 'renderer' => $this));

        return $html;
    }
}
