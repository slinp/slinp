<?php

namespace Slinp\Component\NodeMapper;

use PHPCR\ItemInterface;
use PHPCR\ItemVisitorInterface;

/**
 * This trait fulfils the PHPCR\NodeInterface for classes implementing
 * SlinpNodeInterface
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
trait PhpcrNodeTrait
{
    /**
     * @see PHPCR\NodeInterface#addNode
     */
    public function addNode($relPath, $primaryNodeTypeName = null)
    {
        return $this->getPhpcrNode()->addNode($relPath, $primaryNodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#addNodeAutoNamed
     */
    public function addNodeAutoNamed($nameHint = null, $primaryNodeTypeName = null)
    {
        return $this->getPhpcrNode()->addNodeAutoNamed($nameHint = null, $primaryNodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#orderBefore
     */
    public function orderBefore($srcChildRelPath, $destChildRelPath)
    {
        return $this->getPhpcrNode()->orderBefore($srcChildRelPath, $destChildRelPath);
    }

    /**
     * @see PHPCR\NodeInterface#rename
     */
    public function rename($newName)
    {
        return $this->getPhpcrNode()->rename($newName);
    }

    /**
     * @see PHPCR\NodeInterface#setProperty
     */
    public function setProperty($name, $value, $type = null)
    {
        return $this->getPhpcrNode()->setProperty($name, $value, $type = null);
    }

    /**
     * @see PHPCR\NodeInterface#getNode
     */
    public function getNode($relPath)
    {
        return $this->getPhpcrNode()->getNode($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#getNodes
     */
    public function getNodes($nameFilter = null, $typeFilter = null)
    {
        $ret = array();
        $phpcrNodes = $this->getPhpcrNode()->getNodes($nameFilter, $typeFilter);

        foreach ($phpcrNodes as $phpcrNode) {
            $ret[] = $this->objectBroker()->exchange($phpcrNode);
        }

        return $ret;
    }

    /**
     * @see PHPCR\NodeInterface#getNodeNames
     */
    public function getNodeNames($nameFilter = null, $typeFilter = null)
    {
        return $this->getPhpcrNode()->getNodeNames($nameFilter = null, $typeFilter = null);
    }

    /**
     * @see PHPCR\NodeInterface#getProperty
     */
    public function getProperty($relPath)
    {
        return $this->getPhpcrNode()->getProperty($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#getPropertyValue
     */
    public function getPropertyValue($name, $type=null)
    {
        return $this->getPhpcrNode()->getPropertyValue($name, $type=null);
    }

    /**
     * @see PHPCR\NodeInterface#getPropertyValueWithDefault
     */
    public function getPropertyValueWithDefault($relPath, $defaultValue)
    {
        return $this->getPhpcrNode()->getPropertyValueWithDefault($relPath, $defaultValue);
    }

    /**
     * @see PHPCR\NodeInterface#getProperties
     */
    public function getProperties($nameFilter = null)
    {
        return $this->getPhpcrNode()->getProperties($nameFilter = null);
    }

    /**
     * @see PHPCR\NodeInterface#getPropertiesValues
     */
    public function getPropertiesValues($nameFilter=null, $dereference=true)
    {
        return $this->getPhpcrNode()->getPropertiesValues($nameFilter=null, $dereference=true);
    }

    /**
     * @see PHPCR\NodeInterface#getPrimaryItem
     */
    public function getPrimaryItem()
    {
        return $this->getPhpcrNode()->getPrimaryItem();
    }

    /**
     * @see PHPCR\NodeInterface#getIdentifier
     */
    public function getIdentifier()
    {
        return $this->getPhpcrNode()->getIdentifier();
    }

    /**
     * @see PHPCR\NodeInterface#getIndex
     */
    public function getIndex()
    {
        return $this->getPhpcrNode()->getIndex();
    }

    /**
     * @see PHPCR\NodeInterface#getReferences
     */
    public function getReferences($name = null)
    {
        return $this->getPhpcrNode()->getReferences($name = null);
    }

    /**
     * @see PHPCR\NodeInterface#getWeakReferences
     */
    public function getWeakReferences($name = null)
    {
        return $this->getPhpcrNode()->getWeakReferences($name = null);
    }

    /**
     * @see PHPCR\NodeInterface#hasNode
     */
    public function hasNode($relPath)
    {
        return $this->getPhpcrNode()->hasNode($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#hasProperty
     */
    public function hasProperty($relPath)
    {
        return $this->getPhpcrNode()->hasProperty($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#hasNodes
     */
    public function hasNodes()
    {
        return $this->getPhpcrNode()->hasNodes();
    }

    /**
     * @see PHPCR\NodeInterface#hasProperties
     */
    public function hasProperties()
    {
        return $this->getPhpcrNode()->hasProperties();
    }

    /**
     * @see PHPCR\NodeInterface#getPrimaryNodeType
     */
    public function getPrimaryNodeType()
    {
        return $this->getPhpcrNode()->getPrimaryNodeType();
    }

    /**
     * @see PHPCR\NodeInterface#getMixinNodeTypes
     */
    public function getMixinNodeTypes()
    {
        return $this->getPhpcrNode()->getMixinNodeTypes();
    }

    /**
     * @see PHPCR\NodeInterface#isNodeType
     */
    public function isNodeType($nodeTypeName)
    {
        return $this->getPhpcrNode()->isNodeType($nodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#setPrimaryType
     */
    public function setPrimaryType($nodeTypeName)
    {
        return $this->getPhpcrNode()->setPrimaryType($nodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#addMixin
     */
    public function addMixin($mixinName)
    {
        return $this->getPhpcrNode()->addMixin($mixinName);
    }

    /**
     * @see PHPCR\NodeInterface#removeMixin
     */
    public function removeMixin($mixinName)
    {
        return $this->getPhpcrNode()->removeMixin($mixinName);
    }

    /**
     * @see PHPCR\NodeInterface#setMixins
     */
    public function setMixins(array $mixinNames)
    {
        return $this->getPhpcrNode()->setMixins($mixinNames);
    }

    /**
     * @see PHPCR\NodeInterface#canAddMixin
     */
    public function canAddMixin($mixinName)
    {
        return $this->getPhpcrNode()->canAddMixin($mixinName);
    }

    /**
     * @see PHPCR\NodeInterface#getDefinition
     */
    public function getDefinition()
    {
        return $this->getPhpcrNode()->getDefinition();
    }

    /**
     * @see PHPCR\NodeInterface#update
     */
    public function update($srcWorkspace)
    {
        return $this->getPhpcrNode()->update($srcWorkspace);
    }

    /**
     * @see PHPCR\NodeInterface#getCorrespondingNodePath
     */
    public function getCorrespondingNodePath($workspaceName)
    {
        return $this->getPhpcrNode()->getCorrespondingNodePath($workspaceName);
    }

    /**
     * @see PHPCR\NodeInterface#getSharedSet
     */
    public function getSharedSet()
    {
        return $this->getPhpcrNode()->getSharedSet();
    }

    /**
     * @see PHPCR\NodeInterface#removeSharedSet
     */
    public function removeSharedSet()
    {
        return $this->getPhpcrNode()->removeSharedSet();
    }

    /**
     * @see PHPCR\NodeInterface#removeShare
     */
    public function removeShare()
    {
        return $this->getPhpcrNode()->removeShare();
    }

    /**
     * @see PHPCR\NodeInterface#isCheckedOut
     */
    public function isCheckedOut()
    {
        return $this->getPhpcrNode()->isCheckedOut();
    }

    /**
     * @see PHPCR\NodeInterface#isLocked
     */
    public function isLocked()
    {
        return $this->getPhpcrNode()->isLocked();
    }

    /**
     * @see PHPCR\NodeInterface#followLifecycleTransition
     */
    public function followLifecycleTransition($transition)
    {
        return $this->getPhpcrNode()->followLifecycleTransition($transition);
    }

    /**
     * @see PHPCR\NodeInterface#getAllowedLifecycleTransitions
     */
    public function getAllowedLifecycleTransitions()
    {
        return $this->getPhpcrNode()->getAllowedLifecycleTransitions();
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return $this->getPhpcrNode()->getPath();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getPhpcrNode()->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function getAncestor($depth)
    {
        return $this->getPhpcrNode()->getAncestor();
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->getPhpcrNode()->getParent();
    }

    /**
     * {@inheritDoc}
     */
    public function getDepth()
    {
        return $this->getPhpcrNode()->getDepth();
    }

    /**
     * {@inheritDoc}
     */
    public function getSession()
    {
        return $this->getPhpcrNode()->getSession();
    }

    /**
     * {@inheritDoc}
     */
    public function isNode()
    {
        return $this->getPhpcrNode()->isNode();
    }

    /**
     * {@inheritDoc}
     */
    public function isNew()
    {
        return $this->getPhpcrNode()->isNew();
    }

    /**
     * {@inheritDoc}
     */
    public function isModified()
    {
        return $this->getPhpcrNode()->isModified();
    }

    /**
     * {@inheritDoc}
     */
    public function isSame(ItemInterface $otherItem)
    {
        return $this->getPhpcrNode()->isSame($otherItem);
    }

    /**
     * {@inheritDoc}
     */
    public function accept(ItemVisitorInterface $visitor)
    {
        return $this->getPhpcrNode()->accept();
    }

    /**
     * {@inheritDoc}
     */
    public function revert()
    {
        return $this->getPhpcrNode()->revert();
    }

    /**
     * {@inheritDoc}
     */
    public function remove()
    {
        return $this->getPhpcrNode()->remove();
    }
}
