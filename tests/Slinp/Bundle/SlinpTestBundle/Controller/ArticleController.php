<?php

namespace Slinp\Bundle\SlinpTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Slinp\Bundle\SlinpBundle\Annotation\Route;
use Slinp\Component\NodeMapper\SlinpNodeInterface;
use Slinp\Component\AdminBuilder\View\EditView;
use Slinp\Component\AdminBuilder\AdminViewPrimer;
use Symfony\Component\HttpFoundation\Request;
use Slinp\Component\AdminBuilder\Responder\EditResponder;
use Slinp\Component\AdminBuilder\AdminView;
use Slinp\Component\AdminBuilder\ViewPrimer\Phpcr\Initializer;
use Slinp\Component\AdminBuilder\AdminViewPrimerEvents;

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

    /**
     * @Route(pattern="/edit")
     */
    public function editAction(Request $request)
    {
        $resource = $request->get('_node');
        $view = new AdminView();
        $view->setObject($resource);
        $view->setFormBuilder($this->createFormBuilder());

        $eventDispatcher = $this->get('event_dispatcher');

        $eventDispatcher->addListener(AdminViewPrimerEvents::INIT, array(new Initializer(), 'prime'));

        $viewPrimer = new AdminViewPrimer($eventDispatcher);
        $viewPrimer->primeForNode($view, $resource);

        $responder = new EditResponder($this->get('twig'));

        return $responder->getResponse($request, $view);
    }
}

