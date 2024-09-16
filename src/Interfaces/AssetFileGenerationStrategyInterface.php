<?php

namespace Sendama\Console\Interfaces;

/**
 * Interface AssetFileGeneratorInterface
 *
 * @package Sendama\Console\Interfaces
 */
interface AssetFileGenerationStrategyInterface
{
  /**
   * Generate the asset file.
   *
   * @return int The exit code
   */
  public function generate(): int;
}