<?php

require __DIR__ . '/vendor/autoload.php';

use Sendama\Engine\Game;
use Sendama\Engine\Core\Scenes\TitleScene;
use Sendama\Engine\Core\Scenes\ExampleScene;

function bootstrap(): void
{
  $gameName = '%GAME_NAME%'; // This will be overwritten by the .env file if GAME_NAME is set
  $game = new Game($gameName);

  $titleScene = new TitleScene('Title Screen');
  $titleScene->setTitle($gameName);

  $game->addScenes(
    $titleScene,
    new ExampleScene('Level 01')
  );

  $game
    ->loadSettings()
    ->run();
}

bootstrap();