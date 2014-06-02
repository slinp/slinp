<?php

namespace Slinp\Bundle\SlinpBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;

class InitCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('slinp:init');
        $this->setDescription('Load all node types and initialize root and web nodes');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        # Register node types
        $command = $this->getApplication()->find('doctrine:phpcr:node-type:register');
        $arguments = array(
            '--allow-update' => true,
            '--help',
        );
        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);

        # Initialize Slinp nodes
        $session = $this->getContainer()->get('doctrine_phpcr')->getConnection();
        $root = $session->getRootNode();

        if (!$root->hasNode('slinp')) {
            $slinpNode = $root->addNode('slinp', 'slinp:root');
            $output->writeln('<info>[+]</info> Adding node: slinp');
        } else {
            $slinpNode = $root->getNode('slinp');
        }

        if (!$slinpNode->hasNode('web')) {
            $slinpNode = $slinpNode->addNode('web', 'slinp:webFolder');
            $output->writeln('<info>[+]</info> Adding node: slinp/web');
        }

        $session->save();
    }
}
