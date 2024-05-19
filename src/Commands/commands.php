<?php

use Sendama\Console\Util\Path;

require_once '../../vendor/autoload.php';

$source = Path::join(dirname(__DIR__, 2), 'assets', 'splash.texture');
$target = Path::join(__DIR__, 'splash.texture');

if (! copy($source, $target))
{
  throw new \RuntimeException(sprintf('File "%s" was not copied to "%s"', $source, $target));
}