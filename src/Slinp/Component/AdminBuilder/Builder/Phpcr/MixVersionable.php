<?php

namespace Slinp\Component\AdminBuilder\FormBuilder\Phpcr;

use Slinp\Component\AdminBuilder\FormBuilder\PhpcrAbstractBuilder;
use Slinp\Component\AdminBuilder\Admin;

class MixVersionable extends PhpcrAbstractBuilder
{
    protected function matches($nodeTypeName)
    {
        return $nodeTypeName === 'mix:title';
    }

    public function handleFormBuild(AdminFormBuildEvent $event)
    {
        $object = $event->getObject();

        if (!$object instanceof SlinpNodeInterface) {
            return;
        }

        $formBuilder = $event->getAdmin()->getFormBuilder();
        $formBuilder->add('jcr:title', 'text', array());
    }
}

