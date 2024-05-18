<?php

use Sendama\Console\Commands\GeneratePrefab;
use Sendama\Console\Commands\GenerateScene;
use Sendama\Console\Commands\GenerateScript;
use Sendama\Console\Commands\GenerateSprite;
use Sendama\Console\Commands\NewGame;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

function bootstrap(): void
{
  $composer = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true);
  $app = new Application("Sendama CLI", $composer['version']);

  $app->addCommands([
    new NewGame(),
    new GeneratePrefab(),
    new GenerateScene(),
    new GenerateScript(),
    new GenerateSprite(),
//    new GenerateTilemap(),
//    new GenerateTileset(),
  ]);
}

bootstrap();