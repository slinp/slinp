<?php

namespace Slinp\SlinpBundle\Content;

use PHPCR\NodeInterface;
use Symfony\Component\Yaml\Yaml;
use PHPCR\PropertyType;

class NodeLoaderYaml implements NodeLoader
{
    public function load(NodeInterface $node, $resource)
    {
        $yaml = Yaml::parse(file_get_contents($resource));

        foreach ($yaml as $propertyName => $propertyAttributes) {
            $type = null;
            $value = null;

            if (isset($propertyAttributes['type'])) {
                $type = PropertyType::valueFromName($propertyAttributes['type']);
            }


            if (isset($propertyAttributes['value'])) {
                $value = $propertyAttributes['value'];
            }


            $node->setProperty($propertyName, $value, $type);
        }
    }
}
