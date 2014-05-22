<?php

namespace Slinp\SlinpBundle\Command;

use Symfony\Component\Console\Command\Command;

class ContentLoadCommand extends Command
{
    public function configure()
    {
        $this->setName('slinp:content:load');
        $this->setDescription('Load content from the app/content folder');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
