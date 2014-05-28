<?php

namespace Slinp\SlinpBundle\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SlinpUrlGenerator extends UrlGeneratorInterface
{
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
    }
}
