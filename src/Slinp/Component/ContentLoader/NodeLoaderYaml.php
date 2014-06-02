<?php

namespace Slinp\Component\ContentLoader;

use PHPCR\NodeInterface;
use Slinp\Component\ContentLoader\NodeLoader;
use Symfony\Component\Yaml\Yaml;
use PHPCR\PropertyType;

class NodeLoaderYaml implements NodeLoader
{
    public function load($resource)
    {
        return Yaml::parse(file_get_contents($resource));
    }
}
