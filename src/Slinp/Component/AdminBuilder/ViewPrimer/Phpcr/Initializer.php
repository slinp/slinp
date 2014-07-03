<?php

namespace Slinp\Component\AdminBuilder\ViewPrimer\Phpcr;

use PHPCR\NodeInterface;
use Slinp\Component\AdminBuilder\AdminViewPrimerEvent;
use Slinp\Component\AdminBuilder\DataMapper\PhpcrDataMapper;
use Slinp\Component\AdminBuilder\Form\PhpcrTypeGuesser;

class Initializer
{
    protected $typeGuesser;

    public function __construct(PhpcrTypeGuesser $typeGuesser)
    {
        $this->typeGuesser = $typeGuesser;
    }

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
            $typeGuess = $this->typeGuesser->guessType($property);

            if ($typeGuess) {
                $formBuilder->add($name, $typeGuess->getType(), $typeGuess->getOptions());
            }
        }
    }
}
