<?php

namespace Slinp\Bundle\SlinpAdminBundle\Builder;

class GenericBuilder
{
    public function build($object, $window, $form)
    {
        foreach ($object->getProperties() as $property) {
            $type = $property->getType();

            $formType = $this->formTypeFrom($type);
            $field = $form->add($formType);

            // field, ideal position, weight
            $formLayout->add($field, FormLayout::BLOCK_FORM_LEFT, 50);
        }

        $formLayout->add(new LinkButton('version'), FormLayout::AUX_ACTIONS, 50);
        $formLayout->add(new SubmitButton('submit'), FormLayout::PRIMARY_ACTIONS, 100);
        $formLayout->add(new CancelButton('cancel'), FormLayout::PRIMARY_ACTIONS, 100);
    }
}
