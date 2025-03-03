<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Strategies\AssetFileGeneration\TileMapFileGenerationStrategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:tilemap',
    description: 'Generate a new tilemap',
    aliases: ['generate:map', 'g:map']
)]
class GenerateTilemap extends Command
{
  public function configure(): void
  {
    $this->addArgument('name', InputArgument::REQUIRED, 'The name of the tilemap');
  }

  public function execute(InputInterface $input, OutputInterface $output): int
  {
    $tileMapFileGenerationStrategy = new TileMapFileGenerationStrategy($input, $output, $input->getArgument('name') ?? 'tilemap', 'maps');
    return $tileMapFileGenerationStrategy->generate();
  }
}