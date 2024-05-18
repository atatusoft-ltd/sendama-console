<?php

/**
 * Filter a string to remove any characters that are not alphanumeric or an underscore
 *
 * @param string $string The string to filter.
 * @return string The filtered string.
 */
function filter_string(string $string, string $pattern = '^a-zA-Z0-9_-'): string
{
  $pattern = $pattern ?: '^a-zA-Z0-9_-';
  return preg_replace("/[$pattern]/", '_', $string);
}