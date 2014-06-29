<?php

namespace Slinp\Component\AdminBuilder;

use Symfony\Component\Form\FormBuilderInterface;

class AdminView implements AdminViewIntreface
{
    protected $title;
    protected $object;
    protected $formBuilder;

    public function getTitle() 
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getObject() 
    {
        return $this->object;
    }
    
    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getFormBuilder() 
    {
        return $this->formBuilder;
    }
    
    public function setFormBuilder(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }
}
