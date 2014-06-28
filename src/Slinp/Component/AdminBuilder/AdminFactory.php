<?php

namespace Slinp\Component\AdminBuilder;

use Symfony\Component\HttpFoundation\Request;

class AdminFactory
{
    protected $session;
    protected $formBuilder;
    protected $eventDispatcher;

    public function registerView($viewName, $view)
    {
        $this->views[$viewName] = $view;
    }

    protected function getView($viewName)
    {
        if (!isset($this->views[$viewName])) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid view name "%s". I only know about: "%s"',
                $viewName,
                implode('", "', array_keys($this->views))
            ));
        }

        return $this->views[$viewName];
    }

    public function create($viewName, $node)
    {
        $admin = new Admin();
        $admin->setFormBuilder($this->formBuilder);

        $view = $this->getView($viewName);
        $admin->bindView($view);

        return $admin;
    }
}
