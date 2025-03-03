<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Strategies\AssetFileGeneration\ScriptFileGenerationStrategy;
use Sendama\Console\Util\Config\ComposerConfig;
use Sendama\Console\Util\Config\ProjectConfig;
use Sendama\Console\Util\Inspector;
use Sendama\Console\Util\Path;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'generate:script',
  description: 'Generate a new script',
)]
class GenerateScript extends Command
{
  /**
   * The inspector.
   *
   * @var Inspector|null
   */
  protected ?Inspector $inspector = null;
  /**
   * The project configuration.
   *
   * @var ProjectConfig|null
   */
  protected ?ProjectConfig $projectConfig = null;
  /**
   * The composer configuration.
   *
   * @var ComposerConfig|null
   */
  protected ?ComposerConfig $composerConfig = null;

  public function configure(): void
  {
    $this->inspector = new Inspector(new ArgvInput(), new ConsoleOutput());
    $this
      ->addArgument('name', InputArgument::REQUIRED, 'The name of the script')
      ->addOption('directory', 'd', InputArgument::OPTIONAL, 'The directory to create the script in', '.');
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $generationStrategy = new ScriptFileGenerationStrategy($input, $output, $input->getArgument('name') ?? 'script', 'scripts');
    return $generationStrategy->generate();
  }
}