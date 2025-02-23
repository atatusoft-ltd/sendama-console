<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Strategies\AssetFileGeneration\EventFileGenerationStrategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:event',
    description: 'Generate a new event.'
)]
class GenerateEvent extends Command
{
  public function configure(): void
  {
    $this->addArgument('name', InputArgument::REQUIRED, 'The name of the texture');
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $generator = new EventFileGenerationStrategy($input, $output, $input->getArgument('name') ?? 'custom-event', 'events');
    return $generator->generate();
  }
}