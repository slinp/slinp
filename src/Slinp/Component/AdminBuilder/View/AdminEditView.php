<?php

namespace Slinp\Component\AdminBuilder\AdminView;

class AdminEditView implements AdminViewInterface
{
    protected $eventDispatcher;
    protected $formBuilder;
    protected $twig;

    public function __construct(
        FormBuilder $formBuilder,
        EventDispatcher $eventDispatcher,
        \Twig_Environment $twig
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formBuilder = $formBuilder;
        $this->twig = $twig;
    }

    public function getResponse(Request $request)
    {
        $this->eventDispatcher->dispatch(AdminEvents::PRE_FORM_BUILD, new AdminFormBuildEvent($admin, $request));
        $this->eventDispatcher->dispatch(AdminEvents::FORM_BUILD, new AdminFormBuildEvent($admin, $request));

        return $this->twig->render(
            'slinp_admin_edit.html.twig', array(
                'admin' => $admin,
                'form' => $admin->getFormBuilder()->getForm()->createView()
            )
        );
    }
}
