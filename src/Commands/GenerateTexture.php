<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:texture',
    description: 'Generate a new texture',
    hidden: true
)]
class GenerateTexture extends Command
{
  /**
   * @inheritDoc
   */
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    // TODO: Implement execute() method.
    $output->writeln('Not implemented yet.');

    return Command::SUCCESS;
  }
}