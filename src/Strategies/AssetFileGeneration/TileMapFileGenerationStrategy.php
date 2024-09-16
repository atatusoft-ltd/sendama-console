<?php

namespace Sendama\Console\Strategies\AssetFileGeneration;

use Sendama\Console\Strategies\AssetFileGeneration;

class TileMapFileGenerationStrategy extends TextureFileGenerationStrategy
{

  /**
   * @inheritDoc
   */
  protected function configure(): void
  {
    $this->fileExtension = '.tmap';
    parent::configure();
    $this->content = <<<TXT
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
x                                                                             x
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TXT;

  }
}