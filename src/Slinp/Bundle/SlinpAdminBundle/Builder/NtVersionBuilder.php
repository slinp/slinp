<?php

namespace Slinp\Bundle\SlinpAdminBundle\Builder;

class NtVersionBuilder
{
    public function build($object, $window, $form)
    {
        if ($object->hasNodeType('nt:versionable')) {
            $block = $window->getBlock('auxilary_actions');
            $block->addWidget(new ButtonWidget('version_control'));

            $form->remove(array(
                'jcr:predecessors',
                'jcr:versionHistory',
                'jcr:baseVersion',
                'jcr:isCheckedOut',
            ));
        }
    }
}
