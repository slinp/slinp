<?php

namespace Slinp\SlinpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\SlinpBundle\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route(pattern="/")
     */
    public function showAction($node)
    {
        return $this->render('SlinpBundle:Article:show', $node);
    }

    /**
     * @Route(pattern="/edit")
     */
    public function editAction($node)
    {
        // process some editing
        return $this->render('SlinpBundle:Article:edit', $node);
    }
}
