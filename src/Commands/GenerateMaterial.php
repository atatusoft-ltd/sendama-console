<?php

namespace Sendama\Console\Commands;

use Sendama\Console\Strategies\AssetFileGeneration\MaterialFileGenerationStrategy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate:material',
    description: 'Generate a new physics material',
)]
class GenerateMaterial extends Command
{
    public function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the material');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $strategy = new MaterialFileGenerationStrategy(
            $input,
            $output,
            $input->getArgument('name') ?? 'material',
            'materials',
        );

        return $strategy->generate();
    }
}
