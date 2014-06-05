<?php

namespace Slinp\Bundle\SlinpBundle\Controller;

use Slinp\Bundle\SlinpBundle\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller
{
    /**
     * @Route("/")
     */
    public function defaultAction($resource)
    {
        return $this->render('SlinpBundle:Resource:default.html.twig', array(
            'resource' => $resource,
        ), new Response(null, 404));
    }
}
