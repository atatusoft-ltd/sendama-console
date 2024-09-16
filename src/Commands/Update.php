<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Util\Inspector;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'update',
    description: 'Update the game',
)]
class Update extends Command
{
  public function configure(): void
  {
    $this->addOption('directory', 'd', InputArgument::OPTIONAL, 'The directory of the game', '.');
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $output->writeln($this->getHeader('Updating the game...'));
    $directory = $input->getOption('directory') ?? '.';

    $inspector = new Inspector($input, $output);
    $inspector->validateProjectDirectory($directory);

    # Check if we are in a
    $updateResult = `cd $directory && composer update --ansi`;

    if (! $updateResult ) {
      $output->writeln($this->getHeader('Update failed.', "\e[0;41m"));
      return Command::FAILURE;
    }

    $output->writeln($updateResult);

    return Command::SUCCESS;
  }

  /**
   * Get a header.
   *
   * @param string $text The text to display.
   * @param string $color The color of the header.
   * @return string The header.
   */
  private function getHeader(string $text, string $color = "\e[0;44m"): string
  {
    return sprintf("%s    %s    \e[0m\n", $color, $text);
  }
}