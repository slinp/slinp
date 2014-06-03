<?php

namespace Slinp\Component\NodeMapper\Tests\Integration;

use Symfony\Component\HttpFoundation\Request;
use Slinp\Bundle\SlinpBundle\Test\WebTestCase;
use Slinp\Component\NodeMapper\ObjectBroker;

class ObjectBrokerTest extends WebTestCase
{
    protected $broker;
    protected $session;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('website.xml');

        $ntNameTranslator = $this->getContainer()->get('slinp.util.node_type_name_translator');
        $this->broker = new ObjectBroker($ntNameTranslator);

        $this->session = $this->getContainer()->get('doctrine_phpcr')->getConnection();
    }

    public function testBroker()
    {
        $node = $this->session->getNode('/slinp/web/root/articles/Faster-than-light');
        $this->broker->objectForNode($node);
    }
}

