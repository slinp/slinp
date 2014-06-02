<?php

namespace Slinp\Component\ContentLoader;

use PHPCR\NodeInterface;

interface NodeLoader
{
    public function load($resource);
}
