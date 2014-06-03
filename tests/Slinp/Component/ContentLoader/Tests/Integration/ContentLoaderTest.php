<?php

namespace Slinp\Component\ContentLoader\Tests\Integration;

use Symfony\Component\HttpFoundation\Request;
use Slinp\Bundle\SlinpBundle\Test\WebTestCase;

class ContentLoaderTest extends WebTestCase
{
    protected $contentLoader;
    protected $session;

    public function setUp()
    {
        parent::setUp();

        $this->loadFixtures('empty.xml');
        $this->kernelRoot = $this->getContainer()->getParameter('kernel.root_dir');
        $this->contentLoader = $this->getContainer()->get('slinp.content_loader');
        $this->session = $this->getContainer()->get('doctrine_phpcr')->getConnection();
    }

    public function testLoad()
    {
        $this->contentLoader->load($this->kernelRoot . '/content');

        $rootNode = $this->session->getNode('/slinp/web/root');
        $this->assertEquals('Welcome to the Slinp test application', $rootNode->getPropertyValue('title'));

        $this->session->getNode('/slinp/web/root/barfoo');
        $this->session->getNode('/slinp/web/root/foobar');
    }
}
