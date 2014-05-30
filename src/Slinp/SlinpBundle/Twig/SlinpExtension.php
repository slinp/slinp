<?php

namespace Slinp\SlinpBundle\Twig;

use Slinp\SlinpBundle\Util\SlinpContext;

class SlinpExtension extends \Twig_Extension
{
    protected $slinpContext;

    public function __construct(SlinpContext $slinpContext)
    {
        $this->slinpContext = $slinpContext;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $environment->addGlobal('slinp_context', $this->slinpContext);
    }

    public function getName()
    {
        return 'slinp';
    }
}
