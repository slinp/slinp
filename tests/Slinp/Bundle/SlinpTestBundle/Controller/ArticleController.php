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
use Slinp\Component\AdminBuilder\Form\PhpcrTypeGuesser;

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
        $view->setFormBuilder($this->createFormBuilder($resource));

        $this->configureView();

        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->addListener(AdminViewPrimerEvents::INIT, array(new Initializer(new PhpcrTypeGuesser()), 'prime'));

        $viewPrimer = new AdminViewPrimer($eventDispatcher);
        $viewPrimer->primeForNode($view, $resource);

        $responder = new EditResponder($this->get('twig'));

        return $responder->getResponse($request, $view);
    }

    // example of view configuration
    protected function configureView($view)
    {
        // add the widgets
        $view->widgets->add('main', new ContainerWidget());
        $view->widgets->add('form_container', new FormContainerWidget(array('method' => 'post', 'enctype' => 'fuck')));
        $view->widgets->add('primary_action_container', new ContainerWidget());
        $view->widgets->add('secondary_action_container', new ContainerWidget());
        $view->widgets->add('tertiary_action_container', new ContainerWidget());
        // version control widget for fun
        $view->widgets->add('version_control', new VersionControlWidget());
        // some form buttons
        $view->widgets->add('submit_button', new SubmitButtonWidget());
        $view->widgets->add('submit_and_new_button', new SubmitAndNewButton());
        $view->widgets->add('cancel_button', new CancelButton());

        // configure the layout
        $view->widgets->place(array(
            'form_container', 
            'primary_action_container', 
            'secondary_action_container',
            'tertiary_action_container'
        ))->after('main');

        // postion the buttons in the primary_action_container
        $view->layout->place(array(
            'submit_button',
            'submit_and_new_button',
            'cancel_button'
        ))->in('primary_action_container');
        // position the version_control widget first in the "version_control" container if it exists,
        // and then fallback to the tertiary_action_container
        $view->layout->place(array('version_control'))->in(array('tertiary_action_container', 'version_control'));

        // set the primary container to be "main"
        $view->setPrimaryContainer('main');
        // use the default theme
        $view->setTheme('default');
    }
}

