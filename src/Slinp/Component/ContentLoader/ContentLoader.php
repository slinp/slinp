<?php

namespace Slinp\Component\ContentLoader;

use PHPCR\SessionInterface;
use PHPCR\ItemExistsException;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use PHPCR\PathNotFoundException;
use PHPCR\Util\PathHelper;
use Slinp\Component\ContentLoader\NodeLoaderFactory;
use PHPCR\PropertyType;

class ContentLoader
{
    protected $registry;
    protected $contentPath;
    protected $webPath;
    protected $nodeLoaderFactory;
    protected $loggingClosure;

    public function __construct(ManagerRegistry $registry, NodeLoaderFactory $nodeLoaderFactory, $webPath)
    {
        $this->registry = $registry;
        $this->webPath = $webPath;
        $this->nodeLoaderFactory = $nodeLoaderFactory;
    }

    public function setLoggingClosure(\Closure $closure)
    {
        $this->loggingClosure = $closure;
    }

    protected function log($message)
    {
        if ($this->loggingClosure) {
            $loggingClosure = $this->loggingClosure;
            $loggingClosure($message);
        }
    }

    protected function getPhpcrSession()
    {
        return $this->registry->getConnection();
    }

    public function load($contentPath)
    {
        $this->contentPath = $contentPath;
        $this->loadNode($this->contentPath);
        $this->getPhpcrSession()->save();
    }

    protected function loadNode($path)
    {
        $webPath = sprintf('%s/root%s', $this->webPath, substr($path, strlen($this->contentPath)));
        $session = $this->getPhpcrSession();

        $contentPath = $path . '/node.yml';
        $this->log('Loading: ' . $contentPath);
        if (!file_exists($contentPath)) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find node.yml content file at file path "%s".',
                $contentPath
            ));
        }

        $loader = $this->nodeLoaderFactory->createLoader('yaml');
        $data = $loader->load($contentPath);

        if (!isset($data['jcr:primaryType']['value'])) {
            throw new \InvalidArgumentException(sprintf(
                'No "jcr:primaryType" specified on content path in filesystem "%s".',
                $contentPath
            ));
        }

        $primaryType = $data['jcr:primaryType']['value'];

        unset($data['jcr:primaryType']);

        try {
            $node = $session->getNode($webPath);

            $existingNodeType = $node->getPrimaryNodeType()->getName();
            if ($existingNodeType != $primaryType) {
                throw new \InvalidArgumentException(sprintf(
                    'Content file "%s" has node type "%s" but existing node has node type "%s"',
                    $contentPath, $primaryType, $existingNodeType
                ));

            }
        } catch (PathNotFoundException $e) {
            $parentNodePath = PathHelper::getParentPath($webPath);
            $parentNode = $session->getNode($parentNodePath);
            $nodeName = PathHelper::getNodeName($webPath);
            $node = $parentNode->addNode($nodeName, $primaryType);
        }

        foreach ($data as $propertyName => $propertyAttributes) {
            $type = null;
            $value = null;

            if (isset($propertyAttributes['type'])) {
                $type = PropertyType::valueFromName($propertyAttributes['type']);
            }


            if (isset($propertyAttributes['value'])) {
                $value = $propertyAttributes['value'];
            }


            if ($type) {
                $node->setProperty($propertyName, $value, $type);
            } else {
                $node->setProperty($propertyName, $value);
            }
        }

        $childDirs = $this->getChildDirs($path);

        foreach ($childDirs as $dir) {
            $this->loadNode($dir);
        }
    }

    protected function getChildDirs($path)
    {
        $ret = array();
        $dir = opendir($path);

        while ($file = readdir($dir)) {
            if (in_array($file, array('.', '..'))) {
                continue;
            }

            $filepath = $path . '/' . $file;
            if (filetype($filepath) == 'dir') {
                $ret[] = $filepath;
            }
        }

        return $ret;
    }
}
