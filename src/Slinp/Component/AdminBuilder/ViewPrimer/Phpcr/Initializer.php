<?php

namespace Slinp\Component\AdminBuilder\ViewPrimer\Phpcr;

use PHPCR\NodeInterface;
use Slinp\Component\AdminBuilder\AdminViewPrimerEvent;
use Slinp\Component\AdminBuilder\DataMapper\PhpcrDataMapper;

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
        $formBuilder->setDataMapper(new PhpcrDataMapper());

        foreach ($object->getProperties() as $name => $property) {
            if (is_scalar($property->getValue())) {
                $formBuilder->add($name);
            }
        }
    }

}
