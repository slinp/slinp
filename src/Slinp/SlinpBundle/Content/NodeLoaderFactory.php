<?php

namespace Slinp\SlinpBundle\Content;

class NodeLoaderFactory
{
    public function createLoader($format)
    {
        switch ($format) {
            case 'yaml':
            case 'yml':
                return new NodeLoaderYaml();
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Unkown loader format "%s", cannot create new node loader.',
                    $format
                ));
        }
    }
}
