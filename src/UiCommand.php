<?php

namespace Cube\Ui;

use Cube\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UiCommand extends BaseCommand
{
    protected static $defaultName = 'ui:setup';

    public function configure()
    {
        $this
            ->setDescription('Setup UI package')
            ->setHelp('This command sets up ui package');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        UiService::install($output);
        return self::SUCCESS;
    }
}
