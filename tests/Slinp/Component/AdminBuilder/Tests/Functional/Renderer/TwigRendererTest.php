<?php

namespace Slinp\Component\AdminBuilder\Tests\Functional\Renderer;

use Symfony\Component\HttpFoundation\Request;
use Slinp\Bundle\SlinpBundle\Test\WebTestCase;
use Slinp\Component\AdminBuilder\Widget\ContainerWidget;
use Slinp\Component\AdminBuilder\Widget\TextWidget;
use Slinp\Component\AdminBuilder\Renderer\TwigRenderer;

class TwigRendererTest extends WebTestCase
{
    protected $widget;

    public function setUp()
    {
        parent::setUp();

        $container = new ContainerWidget();

        $formContainer = new ContainerWidget();

        $container->append($formContainer);

        $formContainer->append(new TextWidget('Hello this is some text'));
        $formContainer->append(new TextWidget('This is more text init'));

        $this->widget = $container;
    }
    public function testRenderer()
    {
        $twig = $this->getContainer()->get('twig');
        $renderer = new TwigRenderer($twig, 'slinp_admin_theme_default.html.twig');
        $html = $renderer->render($this->widget);
        $expected = str_replace(' ', '', <<<EOT
<div class="container">
    <div class="container">
    <div class="text">Hello this is some text</div>
<div class="text">This is more text init</div>
</div>
</div>

EOT
        );

        $this->assertEquals($expected, str_replace(' ', '', $html));
    }
}

