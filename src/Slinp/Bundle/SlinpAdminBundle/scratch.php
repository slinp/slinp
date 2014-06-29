<?php

$builder = // ... 

$window = new Window();
$window->setTitle('Foo bar');

$container = new FormContainer();
$container = new Container();

$container->add(new FormWidget(
    $formFactory->create('title', 'text', array()),
    array(
        'priority' => 50,
        'template' => 'field_title.html.twig',
    )
));

$mapping = array(
    'mix:title' => array(
        'jcr:title' => 'jcr_title',
