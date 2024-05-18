<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:prefab',
    description: 'Generate a new prefab'
)]
class GenerateScene extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Generating a new scene...');

        return Command::SUCCESS;
    }
}