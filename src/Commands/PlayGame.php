<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'play',
    description: 'Start playing the game',
    aliases: ['p'],
)]
class PlayGame extends Command
{
  public function configure(): void
  {
    $this->addOption('directory', 'd', InputArgument::OPTIONAL, 'The directory of the game', '.');
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $directory = $input->getOption('directory') ?? '.';
    $sendamaConfigFilename = 'sendama.json';

    if (! $this->isValidDirectory($directory) )
    {
      $output->writeln('Invalid Sendama game directory.');
      return Command::FAILURE;
    }

    $output->writeln('Starting the game...');
    $output->writeln('Game directory: ' . $directory);

    // Open the project config and retrieve the main file
    $config = json_decode(file_get_contents($directory . '/' . $sendamaConfigFilename), true);

    if (! file_exists($directory . '/' . $config['main']) )
    {
      $output->writeln('Main file not found.');
      return Command::FAILURE;
    }

    // Start the game using the main file
    if (false === passthru("php $directory/{$config['main']}" ) )
    {
      $output->writeln('Failed to start the game.');
      return Command::FAILURE;
    }

    return Command::SUCCESS;
  }

  /**
   * Checks if the given directory is a valid Sendama game directory.
   *
   * @param string $directory The directory to check.
   * @return bool True if the directory is a valid Sendama game directory; otherwise, false.
   */
  private function isValidDirectory(string $directory): bool
  {
    return file_exists($directory . '/sendama.json');
  }
}