<?php

namespace Slinp\SlinpBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommandTestCase extends WebTestCase
{
    public function getCommandTesterFor($name)
    {
        $kernel = $this->getContainer()->get('kernel');
        $kernel->boot();
        $application = new Application($kernel);
        foreach ($kernel->getBundles() as $bundle) {
            if ($bundle instanceof Bundle) {
                $bundle->registerCommands($application);
            }
        }
        $command = $application->find($name);
        $commandTester = new CommandTester($command);

        return $commandTester;
    }
}
