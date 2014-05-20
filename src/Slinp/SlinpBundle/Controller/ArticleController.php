<?php

namespace Slinp\SlinpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\SlinpBundle\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route(pattern="/")
     */
    public function showAction()
    {
    }

    /**
     * @Route(pattern="/edit")
     */
    public function editAction()
    {
    }
}
