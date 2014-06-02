<?php

namespace Slinp\Bundle\SlinpBundle\Twig;

use Slinp\Bundle\SlinpBundle\Util\SlinpContext;

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
