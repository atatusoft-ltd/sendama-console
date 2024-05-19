<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:sprite',
    description: 'Generate a new sprite')]
class GenerateSprite extends Command
{
  /**
   * @inheritDoc
   */
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $output->writeln('Generating a new sprite...');

    return Command::SUCCESS;
  }
}