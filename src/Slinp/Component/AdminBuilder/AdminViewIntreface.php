<?php

namespace Slinp\Component\AdminBuilder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;

interface AdminViewIntreface
{
    public function getTitle();
    
    public function setTitle($title);

    public function getObject();
    
    public function setObject($object);

    public function getFormBuilder(); 
    
    public function setFormBuilder(FormBuilderInterface $formBuilder);
}
