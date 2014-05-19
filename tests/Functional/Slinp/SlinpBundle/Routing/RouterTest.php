<?php

namespace Functional\Slinp\SlinpBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouterTest extends WebTestCase
{
    public function testRouting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
