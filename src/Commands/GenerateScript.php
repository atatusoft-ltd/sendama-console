<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:script',
    description: 'Generate a new script'
)]
class GenerateScript extends Command
{
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    // TODO: Implement execute() method.

    return Command::SUCCESS;
  }
}