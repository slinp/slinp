<?php

namespace Slinp\Bundle\SlinpTestBundle\Tests\Functional;

use Slinp\Bundle\SlinpBundle\Test\WebTestCase;

class FileTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('files.xml');
    }

    public function testIndex()
    {
        ob_start();
        $client = $this->createClient();
        $client->request('GET', '/');
        $response = $client->getResponse();
        ob_end_clean();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('image/jpeg', $response->headers->get('Content-Type'));
    }
}
