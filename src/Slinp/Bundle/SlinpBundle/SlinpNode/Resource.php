<?php

namespace Slinp\Bundle\SlinpBundle\SlinpNode;

use Slinp\Bundle\SlinpBundle\SlinpNode\Base;
use Slinp\Component\NodeMapper\SlinpNodeInterface;
use PHPCR\NodeInterface;

/**
 * Resource nodes are resolvable from the web.
 *
 * Any node that is to be accessed from the web should
 * implement this interface.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class Resource extends Standard
{
}
