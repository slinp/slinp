<?php

namespace Slinp\Component\AdminBuilder\ViewPrimer\Phpcr;

use PHPCR\NodeInterface;

abstract class AbstractPrimer
{
    public function prime(AdminViewPrimeEvent $event)
    {
        $view = $event->getView();
        $object = $view->getObject();

        if (!$object instanceof NodeInterface) {
            return;
        }

        if (!$node->isNodeType($this->getTargetNodeTypeName())) {
            return;
        }

        $this->doPrime($view, $object);
    }

}
