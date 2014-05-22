<?php

namespace Functional\Slinp\SlinpBundle\Routing;

use Slinp\SlinpBundle\Routing\SlinpMatcher;
use Symfony\Component\HttpFoundation\Request;
use Slinp\SlinpBundle\Tests\Functional\BaseTestCase;

class ContentLoaderTest extends BaseTestCase
{
    protected $contentLoader;

    public function setUp()
    {
        parent::setUp();

        $this->loadFixtures('empty.xml');
        $this->kernelRoot = $this->getContainer()->getParameter('kernel.root_dir');
        $this->contentLoader = $this->getContainer()->get('slinp.content.content_loader');
        $this->session = $this->getContainer()->get('doctrine_phpcr')->getConnection();
    }

    public function testLoad()
    {
        $this->contentLoader->load($this->kernelRoot . '/content');

        $rootNode = $this->session->getNode('/slinp/web/root');
        $this->assertEquals('Welcome to the Slinp test application', $rootNode->getPropertyValue('title'));

        $barFoo = $this->session->getNode('/slinp/web/root/barfoo');
        $fooBar = $this->session->getNode('/slinp/web/root/foobar');
    }
}

