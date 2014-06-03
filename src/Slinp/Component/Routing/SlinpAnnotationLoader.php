<?php

namespace Slinp\Component\Routing;

use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Routing\Route;

class SlinpAnnotationLoader extends AnnotationClassLoader
{
    public function __construct(Reader $reader)
    {
        $this->setRouteAnnotationClass('Slinp\Bundle\SlinpBundle\Annotation\Route');
        parent::__construct($reader);
    }

    protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot)
    {
        // controller
        $route->setDefault('_controller', sprintf(
            '%s::%s',
            $class->getName(), $method->getName()
        ));
    }
}
