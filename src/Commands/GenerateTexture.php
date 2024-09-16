<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Strategies\AssetFileGeneration\TextureFileGenerationStrategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:texture',
    description: 'Generate a new texture',
)]
class GenerateTexture extends Command
{
  public function configure(): void
  {
    $this->addArgument('name', InputArgument::REQUIRED, 'The name of the texture');
  }

  /**
   * @inheritDoc
   */
  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $textureGenerationStrategy = new TextureFileGenerationStrategy($input, $output, $input->getArgument('name') ?? 'texture', 'textures');
    return $textureGenerationStrategy->generate();
  }
}