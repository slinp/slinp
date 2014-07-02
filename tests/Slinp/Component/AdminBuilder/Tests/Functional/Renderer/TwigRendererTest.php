<?php

namespace Slinp\Component\AdminBuilder\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Slinp\Bundle\SlinpBundle\Test\WebTestCase;
use Slinp\Component\AdminBuilder\Widget\ContainerWidget;
use Slinp\Component\AdminBuilder\Widget\TextWidget;
use Slinp\Component\AdminBuilder\Renderer\TwigRenderer;

class ContentLoaderTest extends WebTestCase
{
    protected $widget;

    public function setUp()
    {
        parent::setUp();

        $container = new ContainerWidget();

        $formContainer = new ContainerWidget();

        $container->append($formContainer);

        $formContainer->append(new TextWidget('Hello this is some text'));

        $this->widget = $container;
    }
    public function testRenderer()
    {
        $twig = $this->getContainer()->get('twig');
        $renderer = new TwigRenderer($twig, 'slinp_admin_theme_default.html.twig');
        $html = $renderer->render($this->widget);

        var_dump($html);die();
    }
}

