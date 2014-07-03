<?php

namespace Slinp\Component\AdminBuilder\Responder;

use Symfony\Component\HttpFoundation\Request;
use Slinp\Component\AdminBuilder\AdminViewIntreface;
use Symfony\Component\HttpFoundation\Response;
use Slinp\Component\AdminBuilder\Renderer\TwigRenderer;

class EditResponder
{
    protected $renderer;

    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getResponse(Request $request, AdminViewIntreface $view)
    {
        return new Response($this->renderer->render(
            $view->getLayoutWidget()
        ), 200);
    }
}
