<?php

namespace Sendama\Console\Enumerations;

/**
 * Class LogOption
 *
 * @package Sendama\Console\Enumerations
 */
enum LogOption: string
{
  case ALL = 'all';
  case ERROR = 'error';
  case DEBUG = 'debug';

  /**
   * Returns the value strings.
   *
   * @return array<string>
   */
  public static function toArray(): array
  {
    return [
      self::ALL->value,
      self::ERROR->value,
      self::DEBUG->value,
    ];
  }
}
