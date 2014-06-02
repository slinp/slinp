<?php

namespace Slinp\SlinpTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\Bundle\SlinpBundle\Annotation\Route;
use Slinp\Bundle\SlinpBundle\SlinpNode\Resource;

class ArticleController extends Controller
{
    /**
     * @Route(pattern="/")
     */
    public function showAction(Resource $resource)
    {
        return $this->render('SlinpTestBundle:Article:show.html.twig', array(
            'node' => $resource
        ));
    }
}

