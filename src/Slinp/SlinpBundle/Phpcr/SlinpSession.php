<?php

namespace Slinp\SlinpBundle\Phpcr;

use PHPCR\SessionInterface;
use PHPCR\CredentialsInterface;
use PHPCR\Util\PathHelper;
use PHPCR\PathNotFoundException;
use PHPCR\NodeInterface;

class SlinpSession implements SessionInterface
{
    protected $session;
    protected $objectBroker;

    public function __construct(SessionInterface $session, ObjectBroker $objectBroker)
    {
        $this->session = $session;
        $this->objectBroker = $objectBroker;
    }

    protected function getSlinpNodes($phpcrNodes)
    {
        $ret = array();
        foreach ($phpcrNodes as $phpcrNode) {
            $ret[] = $this->getSlinpNode($phpcrNode);
        }

        return $ret;
    }

    protected function getSlinpNode(NodeInterface $phpcrNode)
    {
        return $this->objectBroker->objectForNode($phpcrNode);
    }

    public function getRepository()
    {
        return $this->session->getRepository();
    }

    public function getUserID()
    {
        return $this->session->getUserID();
    }

    public function getAttributeNames()
    {
        return $this->session->getAttributeNames();
    }

    public function getAttribute($name)
    {
        return $this->session->getAttribute($name);
    }

    public function getWorkspace()
    {
        return $this->session->getWorkspace();
    }

    public function getRootNode()
    {
        return $this->getSlinpNode($this->session->getRootNode());
    }

    public function impersonate(CredentialsInterface $credentials)
    {
        return $this->session->impersonate($credentials);
    }

    public function getNodeByIdentifier($id)
    {
        return $this->getSlinpNode($this->session->getNodeByIdentifier($id));
    }

    public function getNodesByIdentifier($ids)
    {
        return $this->getSlinpNodes($this->session->getNodesByIdentifier($id));
    }

    public function getItem($path)
    {
        return $this->getSlinpNode($this->session->getItem($path));
    }

    public function getNode($path, $depthHint = -1)
    {
        return $this->getSlinpNode($this->session->getNode($path));
    }

    public function getNodes($paths)
    {
        return $this->getSlinpNodes($this->session->getNodes($paths));
    }

    public function getProperty($path)
    {
        return $this->session->getProperty($path);
    }

    public function getProperties($paths)
    {
        return $this->session->getProperties($paths);
    }

    public function itemExists($path)
    {
        return $this->session->itemExists($path);
    }

    public function nodeExists($path)
    {
        return $this->session->nodeExists($path);
    }

    public function propertyExists($path)
    {
        return $this->session->propertyExists($path);
    }

    public function move($srcAbsPath, $destAbsPath)
    {
        return $this->session->move($srcAbsPath, $destAbsPath);
    }

    public function removeItem($path)
    {
        return $this->session->removeItem($path);
    }

    public function save()
    {
        return $this->session->save();
    }

    public function refresh($keepChanges)
    {
        return $this->session->refresh($keepChanges);
    }

    public function hasPendingChanges()
    {
        return $this->session->hasPendingChanges();
    }

    public function hasPermission($path, $actions)
    {
        return $this->session->hasPermission($path, $actions);
    }

    public function checkPermission($path, $actions)
    {
        return $this->session->checkPermission($path, $actions);
    }

    public function hasCapability($methodName, $target, array $arguments)
    {
        return $this->session->hasCapability($methodNames, $target, $arguments);
    }

    public function importXML($parentAbsPath, $uri, $uuidBehavior)
    {
        return $this->session->importXML($parentAbsPath, $uri, $uuidBehavior);
    }

    public function exportSystemView($path, $stream, $skipBinary, $noRecurse)
    {
        return $this->session->exportSystemView($path, $stream, $skipBinary, $noRecurse);
    }

    public function exportDocumentView($path, $stream, $skipBinary, $noRecurse)
    {
        return $this->session->exportDocumentView($path, $stream, $skipBinary, $noRecurse);
    }

    public function setNamespacePrefix($prefix, $uri)
    {
        return $this->session->setNamespacePrefix($prefix, $uri);
    }

    public function getNamespacePrefixes()
    {
        return $this->session->getNamespacePrefixes();
    }

    public function getNamespaceURI($prefix)
    {
        return $this->session->getNamespaceURI($prefix);
    }

    public function getNamespacePrefix($uri)
    {
        return $this->session->getNamespacePrefix($uri);
    }

    public function logout()
    {
        return $this->session->logout();
    }

    public function isLive()
    {
        return $this->session->isLive();
    }

    public function getAccessControlManager()
    {
        return $this->session->getAccessControlManager();
    }

    public function getRetentionManager()
    {
        return $this->session->getRetentionManager();
    }
}
