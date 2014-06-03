<?php

namespace Slinp\Bundle\SlinpBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ContentLoadCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('slinp:content:load');
        $this->setDescription('Load content from the app/content folder');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $contentLoader = $this->getContainer()->get('slinp.content_loader');
        $contentLoader->setLoggingClosure(function ($message) use ($output) {
            $output->writeln($message);
        });

        $kernelRoot = $this->getContainer()->getParameter('kernel.root_dir');
        $contentLoader->load($kernelRoot . '/content');
    }
}
