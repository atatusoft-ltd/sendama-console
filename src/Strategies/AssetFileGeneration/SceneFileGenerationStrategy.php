<?php

namespace Sendama\Console\Strategies\AssetFileGeneration;

class SceneFileGenerationStrategy extends AbstractAssetFileGenerationStrategy
{

  /**
   * @inheritDoc
   */
  protected function configure(): void
  {
    $this->content = <<<PHP
<?php

namespace {$this->composerConfig->getNamespace()}Scenes;

use Sendama\Engine\Core\Behaviours\SimpleQuitListener;
use Sendama\Engine\Core\Scenes\AbstractScene;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Vector2;

class $this->className extends AbstractScene
{
  public function awake(): void
  {
    // awake is called when the scene is loaded
    \$this->environmentTileMapPath = 'Maps/example';

    // create your game objects here
    \$levelManager = new GameObject('Level Manager');
    \$myGameObject = new GameObject('My Game Object', position: Vector2::one());

    // TODO: Add components to the GameObject
    \$levelManager->addComponent(SimpleQuitListener::class);

    // add the game objects to the scene
    \$this->add(\$levelManager);
    \$this->add(\$myGameObject);
  }
}

PHP;
  }
}