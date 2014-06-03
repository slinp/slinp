<?php

namespace Slinp\Bundle\SlinpBundle\Tests\Functional\Command;

use Slinp\Bundle\SlinpBundle\Test\WebTestCase;
use Slinp\Bundle\SlinpBundle\Test\CommandTestCase;

class InitCommandTest extends CommandTestCase
{
    public function testInitCommand()
    {
        $tester = $this->getCommandTesterFor('slinp:init');
        $tester->execute(array());
        $output = $tester->getDisplay();
        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertContains(<<<EOT
[+] Adding node: slinp
[+] Adding node: slinp/web
EOT
        , $tester->getDisplay());
    }
}
