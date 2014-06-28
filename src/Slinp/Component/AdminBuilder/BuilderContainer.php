<?php

namespace Slinp\Component\AdminBuilder;

class BuilderContainer
{
    protected $builders = array();

    public function registerBuilder(NodeTypeBuilderInterface $builder)
    {
        $this->builders[$builder->getTarget()] = $builder;
    }

    public function buildAdmin($node)
    {
        $superTypes = $node->getSupertypeNames();

        foreach ($superTypeNames as $superTypeName) {
            if (isset($this->builders[$superTypeName])) {
                $this->builders[$superTypesName]->process($node);
            }
        }
    }

    {
        return $this->builders[$target];
    }
}
