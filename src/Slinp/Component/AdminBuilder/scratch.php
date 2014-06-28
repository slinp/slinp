<?php

// ADMIN ADMIN ADMIN ADMIN ADMIN
// =============================
//
$node = new MyNode;

$context = new Context();
$context->setFormView($form->getForm());

// symfony form builder
$formBuilder = new FormBuilder();

// first we prepare the form with *all* the fields contained in the node type
$nodeFieldGenerator = new NodeFieldBuilder($formBuilder, $phpcrSession->getNodeTypeManager());
$nodeFieldGenerator->buildFromNode($node);

// the page object holds all the widgets and the form builder
$page = new Page();
$page->setFormBuilder($formBuilder);
$page->setObject($node);

// the processor will run the page through filters which do stuff based on
// the node type (or other criteria, its up to them)
$processor = new BuilderProcessor($page);
$processor->register(new MixTitleBuilder());
$processor->register(new MixVersionableBuilder());



// FILTER FILTER FILTER FILTER
// ===========================
//

class NtBaseProcessor
{
    public function supports(Page $page)
    {
        $object = $page->getObject();
        if ($object instanceof NodeInterface) {
            if (in_array('nt:base', $object->getSupertypeNames())) {
                return true;
            }
        }

        $page->addWidget('primary_actions', new SubmitButtonWidget(array(
            'title' => 'Submit',
            'form' => 'main',
        )));
    }

    public function process(Page $page)
    {
        $page->setTitle($page->getObject()->getTitle());
    }
}

class MixVersionableProcessor
{
    public function supports(Page $page)
    {
        $object = $page->getObject();
        if ($object instanceof NodeInterface) {
            if (in_array('mix:versionable', $object->getSupertypeNames())) {
                return true;
            }
        }
    }

    public function process(Page $page) 
    {
        $page->addWidget('auxilliary', new VersionWidget());
        $page->addWidget('attributes', new TemplateWidget('Slinp/Version/attributes.html.twig'));
        $page->getFormGenerator()->blacklistFields(array(
            'jcr:versionHistory',
            'jcr:predecessors',
            'jcr:baseVersion',
        ));
            
    }
}
