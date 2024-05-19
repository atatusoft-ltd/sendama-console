<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'generate:tileset',
  description: 'Generate a new tileset',
  hidden: true
)]
class GenerateTileset extends Command
{
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    // TODO: Implement execute() method.
    $output->writeln('Not implemented yet.');

    return Command::SUCCESS;
  }
}