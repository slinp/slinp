<?php

namespace Slinp\SlinpBundle\Content;

use PHPCR\SessionInterface;
use PHPCR\ItemExistsException;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use PHPCR\PathNotFoundException;
use PHPCR\Util\PathHelper;

class ContentLoader
{
    protected $registry;
    protected $contentPath;
    protected $webPath;
    protected $nodeLoaderFactory;

    public function __construct(ManagerRegistry $registry, NodeLoaderFactory $nodeLoaderFactory, $webPath)
    {
        $this->registry = $registry;
        $this->webPath = $webPath;
        $this->nodeLoaderFactory = $nodeLoaderFactory;
    }

    protected function getPhpcrSession()
    {
        return $this->registry->getConnection();
    }

    public function load($contentPath)
    {
        $this->contentPath = $contentPath;
        $this->loadNode($this->contentPath);
    }

    protected function loadNode($path)
    {
        $webPath = sprintf('%s/root%s', $this->webPath, substr($path, strlen($this->contentPath)));
        $session = $this->getPhpcrSession();

        $contentPath = $path . '/node.yml';
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

        $session->save();
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
