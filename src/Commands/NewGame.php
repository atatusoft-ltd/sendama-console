<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Util\Path;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'new:game',
    description: 'Create a new game'
)]
class NewGame extends Command
{
  private string $targetDirectory = '';

  public function configure(): void
  {
    $this
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the game')
      ->addArgument('directory', InputArgument::OPTIONAL, 'The directory to create the game in', getcwd());
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    // Configure the target directory
    $output->writeln('Creating a new game...');
    $projectName = $input->getArgument('name');
    $this->targetDirectory = Path::join(
      $this->targetDirectory,
      strtolower(filter_string($projectName))
    );

    // Create project directory
    if (! mkdir($this->targetDirectory) && ! is_dir($this->targetDirectory))
    {
      throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->targetDirectory));
    }

    // Create project structure

    // Create project files

    // Create project configuration

    // Install dependencies

    // Done
    return Command::SUCCESS;
  }
}