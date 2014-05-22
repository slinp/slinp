<?php

namespace Slinp\SlinpBundle\Content;

use PHPCR\NodeInterface;
use Symfony\Component\Yaml\Yaml;
use PHPCR\PropertyType;

class NodeLoaderYaml implements NodeLoader
{
    public function load($resource)
    {
        return Yaml::parse(file_get_contents($resource));
    }
}
