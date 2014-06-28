<?php

namespace Slinp\Component\AdminBuilder\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Slinp\Component\NodeMapper\SlinpNodeInterface;

class SlinpDataMapper implements DataMapperInterface
{
    protected $phpcrDataMapper;

    public function __construct(PhpcrDataMapper $phpcrDataMapper)
    {
        $this->phpcrDataMapper = $phpcrDataMapper;
    }

    private function validateData($data)
    {
        if (!$data instanceof SlinpNodeInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Form data must be an instance of SlinpNodeInterface'
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function mapDataToForms($data, $forms)
    {
        $this->validateData($data);
        $this->phpcrDataMapper->mapDataToForm($data->node(), $forms);
    }

    /**
     * {@inheritDoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        $this->validateData($data);
        $this->phpcrDataMapper->mapFormsToData($forms, $data->node());
    }
}
