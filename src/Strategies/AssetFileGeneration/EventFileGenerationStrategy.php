<?php

namespace Sendama\Console\Strategies\AssetFileGeneration;

use Sendama\Console\Strategies\AssetFileGeneration\AbstractAssetFileGenerationStrategy;

class EventFileGenerationStrategy extends AbstractAssetFileGenerationStrategy
{
  protected string $suffix = 'Event';

  /**
   * @inheritDoc
   */
  protected function configure(): void
  {
    $this->content = <<<PHP
<?php

namespace {$this->composerConfig->getNamespace()}Events;

use Sendama\Engine\Events\Enumerations\EventType;
use Sendama\Engine\Events\Event;

/**
 * {$this->className} class.
 * 
 * @package {$this->composerConfig->getNamespace()}Events
 */
readonly class $this->className extends Event
{
}
PHP;

  }
}