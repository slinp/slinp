<?php

namespace Slinp\Component\AdminBuilder\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use PHPCR\NodeInterface;

class PhpcrDataMapper implements DataMapperInterface
{
    private function validateData($data)
    {
        if (!$data instanceof NodeInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Form data must be an instance of PHPCR\NodeInterface'
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function mapDataToForms($data, $forms)
    {
        $this->validateData($data);

        foreach ($forms as $form) {
            $propertyPath = $form->getPropertyPath();
            $config = $form->getConfig();

            $value = $data->getPropertyValue((string) $propertyPath);

            // this is very naive
            $form->setData($value);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $this->validateData($data);
        foreach ($forms as $form) {
            $data->setPropertyValue($form->getPropertyPath(), $form->getData());
        }
    }
}
