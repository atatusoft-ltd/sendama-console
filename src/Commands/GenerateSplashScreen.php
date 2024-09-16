<?php

namespace Sendama\Console\Commands;

use Amasiye\Figlet\Figlet;
use Amasiye\Figlet\FontName;
use Exception;
use Sendama\Console\Util\Path;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:splash-screen',
    description: 'Generate a new splash screen',
    aliases: ['g:splash', 'splash']
)]
class GenerateSplashScreen extends Command
{
  public function configure(): void
  {
    $this->addArgument('text', InputArgument::REQUIRED, 'The text of the splash screen');
    $this->addOption(
      'font',
      'f', InputOption::VALUE_REQUIRED,
      'The font of the splash screen',
      FontName::BASIC->value
    );
    $this->addOption(
      'directory',
      'd',
      InputArgument::OPTIONAL,
      'The directory of the splash screen',
      ''
    );
  }

  /**
   * @throws Exception
   */
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $text = $input->getArgument('text');
    $font = $input->getOption('font');
    $directory = $input->getOption('directory');

    $figlet = new Figlet();
    $figlet
      ->setFont($font);

    $render = $figlet->render($text);

    if (! $directory) {
      $output->writeln($render);
    } else {
      $filename = Path::join(Path::getWorkingDirectoryAssetsPath(), $directory, 'splash.texture');

      if (! file_exists(dirname($filename))) {
        mkdir(dirname($filename), 0777, true);
      }

      if (! file_put_contents($filename, $render) ) {
        $output->writeln('<error>Failed to generate splash screen.</error>');
      } else {
        $output->writeln('<info>Splash screen generated successfully.</info>');
      }
    }

    return Command::SUCCESS;
  }
}