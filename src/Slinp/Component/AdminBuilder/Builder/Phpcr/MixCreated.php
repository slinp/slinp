<?php

namespace Slinp\Component\AdminBuilder\FormBuilder\Phpcr;

use Slinp\Component\AdminBuilder\Admin;
use Slinp\Component\AdminBuilder\FormBuilder\PhpcrAbstractBuilder;

class MixCreated extends PhpcrAbstractBuilder
{
    protected function matches($nodeTypeName)
    {
        return $nodeTypeName === 'mix:created';
    }

    protected function buildAdmin(Admin $admin, $object)
    {
        $formBuilder = $event->getAdmin()->getFormBuilder();
        $formBuilder->add('jcr:created', 'datetime', array(
            'disabled' => true
        ));
    }
}
