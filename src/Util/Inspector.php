<?php

namespace Sendama\Console\Util;

use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Inspector
{
  public function __construct(
    protected InputInterface $input,
    protected OutputInterface $output
  )
  {
  }

  /**
   * Check if the given path is a valid project directory.
   *
   * @param string|null $path The path to check.
   * @return void
   */
  public function validateProjectDirectory(?string $path = null): void
  {
    $path = $path ?? getcwd();
    if (! is_dir($path) )
    {
      throw new InvalidArgumentException("Directory $path not found.");
    }

    # Check for a valid composer file
    $composerConfigPath = Path::join($path, 'composer.json');

    if (! file_exists($composerConfigPath) )
    {
      throw new RuntimeException("Composer file not found.");
    }

    $composerConfigData = json_decode(file_get_contents(Path::join($path . '/composer.json')), true);

    if (! $composerConfigData )
    {
      throw new RuntimeException("Invalid composer file.");
    }

    # Check composer file for the presence of the engine package
    if (! isset($composerConfigData['require']['sendamaphp/engine']) )
    {
      throw new RuntimeException("Engine package not found in composer file.");
    }

    # Check for sendama.json file
    if (! file_exists(Path::join($path, 'sendama.json')) )
    {
      throw new RuntimeException("sendama.json file not found.");
    }
  }
}