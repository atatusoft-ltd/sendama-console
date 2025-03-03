<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Strategies\AssetFileGeneration\SceneFileGenerationStrategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'generate:scene',
  description: 'Generate a new scene',
)]
class GenerateScene extends Command
{
  public function configure(): void
  {
    $this->addArgument('name', InputArgument::REQUIRED, 'The name of the scene');
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $sceneGenerationStrategy = new SceneFileGenerationStrategy($input, $output, $input->getArgument('name') ?? 'scene', 'scenes');
    return $sceneGenerationStrategy->generate();
  }
}