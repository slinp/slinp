<?php

namespace Slinp\Component\AdminBuilder\ViewPrimer\Phpcr;

use PHPCR\NodeInterface;
use Slinp\Component\AdminBuilder\AdminViewPrimerEvent;

class Initializer
{
    public function prime(AdminViewPrimerEvent $event)
    {
        $view = $event->getView();
        $object = $view->getObject();

        if (!$object instanceof NodeInterface) {
            return;
        }

        $view->setTitle($object->getName());
        $formBuilder = $view->getFormBuilder();

        foreach ($object->getProperties() as $name => $property) {
            $formBuilder->add($name);
        }
    }

}
