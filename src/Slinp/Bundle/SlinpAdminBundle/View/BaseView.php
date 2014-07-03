<?php

namespace Slinp\Bundle\SlinpAdminBundle\View;

use Slinp\Component\AdminBuilder\AdminView;
use Slinp\Component\AdminBuilder\Widget\LayoutWidget;

class BaseView extends AdminView
{
    public function configure()
    {
        $layout = new LayoutWidget();
        $layout
            ->append(DefaultBlock::MAIN, new ContainerWidget())
                ->append(DefaultBlock::HELP, new ContainerWidget())
                ->append(DefaultBlock::FORM, new FormWidget())
                    ->setEncType('text/html')
                    ->setMethod('POST')
                    ->append(DefaultBlock::FORM_BUTTONS, new ContainerWidget());

        $this->setLayoutWidget($layout);
    }
}

