<?php

namespace Slinp\SlinpBundle\Tests\Functional\Command;

use Slinp\Bundle\SlinpBundle\Test\WebTestCase;
use Slinp\Bundle\SlinpBundle\Test\CommandTestCase;

class ContentLoadCommandTest extends CommandTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures('empty.xml');
    }

    public function testInitCommand()
    {
        $tester = $this->getCommandTesterFor('slinp:content:load');
        $tester->execute(array());
        $output = $tester->getDisplay();
        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertContains(<<<EOT
Loading: /home/daniel/www/slinp/slinp/tests/Resources/app/content/node.yml
EOT
        , $tester->getDisplay());

        $session = $this->getContainer()->get('doctrine_phpcr')->getConnection();
        $session->getNode('/slinp/web/root');
        $session->getNode('/slinp/web/root/barfoo');
        $session->getNode('/slinp/web/root/foobar');
    }
}

