<?php

namespace Slinp\SlinpBundle\Content;

use PHPCR\SessionInterface;
use PHPCR\ItemExistsException;

class ContentLoader
{
    protected $session;
    protected $contentPath;
    protected $webPath;

    public function __construct(SessionInterface $session, NodeLoaderFactory $nodeLoaderFactory, $contentPath, $webPath)
    {
        $this->session = $session;
        $this->contentPath = $contentPath;
        $this->webPath = $webPath;
    }

    public function load()
    {
        $this->loadNode($this->contentPath);
    }

    protected function loadNode($path)
    {
        $webPath = sprintf('%s/root%s', $this->webPath, substr($path, strlen($this->contentPath)));

        try {
            $node = $session->getNode($webPath);
        } catch (ItemExistsException $e) {
            $parentNodePath = PathHelper::getParentPath($webPath);
            $parentNode = $session->getNode($path);
            $nodeName = PathHelper::getNodeName($webPath);
            $node = $parentNode->createNode($nodeName);
        }

        $contentPath = $path . '/node.yml';
        if (!file_exists($contentPath)) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find node.yml content file at file path "%s".',
                $contentPath
            ));
        }

        $loader = $this->nodeLoaderFactory->createLoader('yaml');

        $loader->load($contentPath, $node);
    }
}
