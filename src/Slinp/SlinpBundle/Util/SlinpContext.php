<?php

namespace Slinp\SlinpBundle\Util;

use Slinp\SlinpBundle\Phpcr\SlinpSession;

class SlinpContext
{
    protected $webRoot;
    protected $session;

    public function __construct(SlinpSession $session, $webRoot)
    {
        $this->session = $session;
        $this->webRoot = $webRoot;
    }

    public function getWebRootNode()
    {
        return $this->session->getNode($this->webRoot . '/root');
    }
}
