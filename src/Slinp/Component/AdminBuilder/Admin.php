<?php

namespace Slinp\Component\AdminBuilder;

class Admin
{
    protected $formBuilder;
    protected $view;

    public function setFormBuilder(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function bindView(AdminViewInterface $view)
    {
        $view->setAdmin($this);
        $this->view = $view;
    }

    public function getView()
    {
        if (!$this->view) {
            throw new \RuntimeException(
                'No view has been bound to this admin instance.'
            );
        }

        return $this->view;
    }
}
