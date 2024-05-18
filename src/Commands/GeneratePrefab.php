<?php

namespace Sendama\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(
    name: 'generate:prefab',
    description: 'Generate a new prefab'
)]
class GeneratePrefab extends Command
{

}