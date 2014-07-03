<?php

namespace Slinp\Bundle\SlinpAdminBundle\View;

use Slinp\Component\AdminBuilder\AdminView;
use Slinp\Component\AdminBuilder\Widget\LayoutWidget;

class EditView extends EditView
{
    public function configure()
    {
        parent::configure();

        $this->get(DefaultBlcok::FORM)
            ->append('form', new FormWidget())
                ->setFormBuilder($this->getFormBuilder());

        $this->get(DefaultBlock::FORM_BUTTONS)
            ->append('submit', new SubmitButton)
                ->setValue('Submit')
            ->getParent()
            ->append('submit_and_new', new SubmitAndNewButton())
                ->setValue('Submit and new')
            ->getParent()
            ->append('cancel', new CancelButton())
                ->setValue('Cancel');
    }
}


