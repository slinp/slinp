<?php

namespace Slinp\Bundle\SlinpTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\Bundle\SlinpBundle\Annotation\Route;
use Slinp\Component\NodeMapper\SlinpNodeInterface;

class ArticleController extends Controller
{
    /**
     * @Route(pattern="/")
     */
    public function showAction(SlinpNodeInterface $resource)
    {
        return $this->render('SlinpTestBundle:Article:show.html.twig', array(
            'node' => $resource
        ));
    }
}

