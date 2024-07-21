<?php

namespace Sendama\Console\Util\Config\Interfaces;

/**
 * Interface ConfigInterface
 *
 * @package Sendama\Console\Util\Config\Interfaces
 */
interface ConfigInterface
{
  /**
   * Gets the value at the specified path.
   *
   * @param string $path The path.
   * @return mixed The value.
   */
  public function get(string $path): mixed;

  /**
   * Sets the value at the specified path.
   *
   * @param string $path The path.
   * @param mixed $value The value.
   * @return void
   */
  public function set(string $path, mixed $value): void;

  /**
   * Loads the configuration.
   *
   * @return self
   */
  public function load(): self;

  /**
   * Saves the configuration.
   *
   * @return int|false The number of bytes written, or false on failure.
   */
  public function commit(): int|false;
}