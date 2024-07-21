<?php

namespace Sendama\Console\Util\Config;

use Sendama\Console\Util\Config\AbstractConfig;

/**
 * Class ProjectConfig represents a project configuration.
 *
 * @package Sendama\Console\Util\Config
 */
class ProjectConfig extends AbstractConfig
{
  protected string $filename = 'sendama.json';
}