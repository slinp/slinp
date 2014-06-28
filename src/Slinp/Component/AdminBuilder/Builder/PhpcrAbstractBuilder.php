<?php

namespace Slinp\Component\AdminBuilder\FormBuilder;

use PHPCR\NodeInterface;

abstract class PhpcrAbstractBuilder
{
    protected $nodeTypeManager;

    public function __construct(NodeTypeManager $nodeTypeManager)
    {
        $this->nodeTypeManager = $nodeTypeManager;
    }

    private function normalize($object)
    {
        if ($object instanceof NodeInterface) {
            return $object;
        }

        if ($object instanceof SlinpNodeInterface) {
            return $object->node();
        }

        return $object;
    }

    public function handleFormBuild(AdminFormBuildEvent $event)
    {
        $object = $event->getObject();
        $object = $this->normalize($object);

        if (!$object instanceof NodeInterface) {
            return;
        }

        $this->buildForm($event->getAdmin(), $event->getObject());
    }
}

