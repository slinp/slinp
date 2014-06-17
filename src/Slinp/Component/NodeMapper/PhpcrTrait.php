<?php

namespace Slinp\Component\NodeMapper\PhpcrTrait;

/**
 * This trait fulfils the PHPCR\NodeInterface for classes implementing
 * SlinpNodeInterface
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
trait PhpcrTrait
{
    /**
     * @see PHPCR\NodeInterface#addNode
     */
    public function addNode($relPath, $primaryNodeTypeName = null)
    {
        return $this->_node()->addNode($relPath, $primaryNodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#addNodeAutoNamed
     */
    public function addNodeAutoNamed($nameHint = null, $primaryNodeTypeName = null)
    {
        return $this->_node()->addNodeAutoNamed($nameHint = null, $primaryNodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#orderBefore
     */
    public function orderBefore($srcChildRelPath, $destChildRelPath)
    {
        return $this->_node()->orderBefore($srcChildRelPath, $destChildRelPath);
    }

    /**
     * @see PHPCR\NodeInterface#rename
     */
    public function rename($newName)
    {
        return $this->_node()->rename($newName);
    }

    /**
     * @see PHPCR\NodeInterface#setProperty
     */
    public function setProperty($name, $value, $type = null)
    {
        return $this->_node()->setProperty($name, $value, $type = null);
    }

    /**
     * @see PHPCR\NodeInterface#getNode
     */
    public function getNode($relPath)
    {
        return $this->_node()->getNode($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#getNodes
     */
    public function getNodes($nameFilter = null, $typeFilter = null)
    {
        $ret = array();
        $phpcrNodes = $this->_nodes($nameFilter, $typeFilter);

        foreach ($phpcrNodes as $phpcrNode) {
            $ret[] = $this->_objectBroker()->exchange($phpcrNode);
        }

        return $ret;
    }

    /**
     * @see PHPCR\NodeInterface#getNodeNames
     */
    public function getNodeNames($nameFilter = null, $typeFilter = null)
    {
        return $this->_node()->getNodeNames($nameFilter = null, $typeFilter = null);
    }

    /**
     * @see PHPCR\NodeInterface#getProperty
     */
    public function getProperty($relPath)
    {
        return $this->_node()->getProperty($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#getPropertyValue
     */
    public function getPropertyValue($name, $type=null)
    {
        return $this->_node()->getPropertyValue($name, $type=null);
    }

    /**
     * @see PHPCR\NodeInterface#getPropertyValueWithDefault
     */
    public function getPropertyValueWithDefault($relPath, $defaultValue)
    {
        return $this->_node()->getPropertyValueWithDefault($relPath, $defaultValue);
    }

    /**
     * @see PHPCR\NodeInterface#getProperties
     */
    public function getProperties($nameFilter = null)
    {
        return $this->_node()->getProperties($nameFilter = null);
    }

    /**
     * @see PHPCR\NodeInterface#getPropertiesValues
     */
    public function getPropertiesValues($nameFilter=null, $dereference=true)
    {
        return $this->_node()->getPropertiesValues($nameFilter=null, $dereference=true);
    }

    /**
     * @see PHPCR\NodeInterface#getPrimaryItem
     */
    public function getPrimaryItem()
    {
        return $this->_node()->getPrimaryItem();
    }

    /**
     * @see PHPCR\NodeInterface#getIdentifier
     */
    public function getIdentifier()
    {
        return $this->_node()->getIdentifier();
    }

    /**
     * @see PHPCR\NodeInterface#getIndex
     */
    public function getIndex()
    {
        return $this->_node()->getIndex();
    }

    /**
     * @see PHPCR\NodeInterface#getReferences
     */
    public function getReferences($name = null)
    {
        return $this->_node()->getReferences($name = null);
    }

    /**
     * @see PHPCR\NodeInterface#getWeakReferences
     */
    public function getWeakReferences($name = null)
    {
        return $this->_node()->getWeakReferences($name = null);
    }

    /**
     * @see PHPCR\NodeInterface#hasNode
     */
    public function hasNode($relPath)
    {
        return $this->_node()->hasNode($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#hasProperty
     */
    public function hasProperty($relPath)
    {
        return $this->_node()->hasProperty($relPath);
    }

    /**
     * @see PHPCR\NodeInterface#hasNodes
     */
    public function hasNodes()
    {
        return $this->_node()->hasNodes();
    }

    /**
     * @see PHPCR\NodeInterface#hasProperties
     */
    public function hasProperties()
    {
        return $this->_node()->hasProperties();
    }

    /**
     * @see PHPCR\NodeInterface#getPrimaryNodeType
     */
    public function getPrimaryNodeType()
    {
        return $this->_node()->getPrimaryNodeType();
    }

    /**
     * @see PHPCR\NodeInterface#getMixinNodeTypes
     */
    public function getMixinNodeTypes()
    {
        return $this->_node()->getMixinNodeTypes();
    }

    /**
     * @see PHPCR\NodeInterface#isNodeType
     */
    public function isNodeType($nodeTypeName)
    {
        return $this->_node()->isNodeType($nodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#setPrimaryType
     */
    public function setPrimaryType($nodeTypeName)
    {
        return $this->_node()->setPrimaryType($nodeTypeName);
    }

    /**
     * @see PHPCR\NodeInterface#addMixin
     */
    public function addMixin($mixinName)
    {
        return $this->_node()->addMixin($mixinName);
    }

    /**
     * @see PHPCR\NodeInterface#removeMixin
     */
    public function removeMixin($mixinName)
    {
        return $this->_node()->removeMixin($mixinName);
    }

    /**
     * @see PHPCR\NodeInterface#setMixins
     */
    public function setMixins(array $mixinNames)
    {
        return $this->_node()->setMixins($mixinNames);
    }

    /**
     * @see PHPCR\NodeInterface#canAddMixin
     */
    public function canAddMixin($mixinName)
    {
        return $this->_node()->canAddMixin($mixinName);
    }

    /**
     * @see PHPCR\NodeInterface#getDefinition
     */
    public function getDefinition()
    {
        return $this->_node()->getDefinition();
    }

    /**
     * @see PHPCR\NodeInterface#update
     */
    public function update($srcWorkspace)
    {
        return $this->_node()->update($srcWorkspace);
    }

    /**
     * @see PHPCR\NodeInterface#getCorrespondingNodePath
     */
    public function getCorrespondingNodePath($workspaceName)
    {
        return $this->_node()->getCorrespondingNodePath($workspaceName);
    }

    /**
     * @see PHPCR\NodeInterface#getSharedSet
     */
    public function getSharedSet()
    {
        return $this->_node()->getSharedSet();
    }

    /**
     * @see PHPCR\NodeInterface#removeSharedSet
     */
    public function removeSharedSet()
    {
        return $this->_node()->removeSharedSet();
    }

    /**
     * @see PHPCR\NodeInterface#removeShare
     */
    public function removeShare()
    {
        return $this->_node()->removeShare();
    }

    /**
     * @see PHPCR\NodeInterface#isCheckedOut
     */
    public function isCheckedOut()
    {
        return $this->_node()->isCheckedOut();
    }

    /**
     * @see PHPCR\NodeInterface#isLocked
     */
    public function isLocked()
    {
        return $this->_node()->isLocked();
    }

    /**
     * @see PHPCR\NodeInterface#followLifecycleTransition
     */
    public function followLifecycleTransition($transition)
    {
        return $this->_node()->followLifecycleTransition($transition);
    }

    /**
     * @see PHPCR\NodeInterface#getAllowedLifecycleTransitions
     */
    public function getAllowedLifecycleTransitions()
    {
        return $this->_node()->getAllowedLifecycleTransitions();
    }
}
