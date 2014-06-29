<?php

namespace Slinp\Component\AdminBuilder\Responder;

use Symfony\Component\HttpFoundation\Request;
use Slinp\Component\AdminBuilder\AdminViewIntreface;
use Symfony\Component\HttpFoundation\Response;

class EditResponder
{
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getResponse(Request $request, AdminViewIntreface $view)
    {
        return new Response($this->twig->render(
            'slinp_admin_edit.html.twig', array(
                'view' => $view,
                'form' => $view->getFormBuilder()->getForm()->createView()
            )
        ), 200);
    }
}
