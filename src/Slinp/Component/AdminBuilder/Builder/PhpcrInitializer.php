<?php

namespace Slinp\Component\AdminBuilder\FormBuilder;

use PHPCR\NodeInterface;

class SlinpInitializer
{
    protected $dataMapper;

    public function __construct(SlinpDataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    public function initialize(AdminFormBuildEvent $event)
    {
        $object = $event->getObject();

        if (!$object instanceof NodeInterface) {
            return;
        }

        $admin = $event->getAdmin();
        $admin->getFormBuilder()->setDataMapper($this->slinpDataMapper);
    }
}
