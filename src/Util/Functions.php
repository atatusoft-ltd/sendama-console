<?php

/**
 * Filter a string to remove any characters that are not alphanumeric or an underscore
 *
 * @param string $string The string to filter.
 * @return string The filtered string.
 */
function filter_string(
  string $string,
  string $pattern = '^a-zA-Z0-9_-',
  string $separator = '-'
): string
{
  $pattern = $pattern ?: '^a-zA-Z0-9_-';
  return preg_replace("/[$pattern]/", $separator, $string);
}

/**
 * Convert a string to pascal case.
 *
 * @param string $string The string to convert.
 * @return string The pascal case string.
 */
function to_pascal_case(string $string): string
{
  $chunks = preg_split('/[^a-zA-Z0-9]/', $string);

  $output = '';

  foreach ($chunks as $chunk)
  {
    $output .= ucfirst(strtolower($chunk));
  }

  return $output;
}

/**
 * Convert a string to camel case.
 *
 * @param string $string The string to convert.
 * @return string The camel case string.
 */
function to_camel_case(string $string): string
{
  return lcfirst(to_pascal_case($string));
}

/**
 * Convert a string to snake case.
 *
 * @param string $string The string to convert.
 * @return string The snake case string.
 */
function to_snake_case(string $string): string
{
  return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
}

/**
 * Convert a string to kebab case.
 *
 * @param string $string The string to convert.
 * @return string The kebab case string.
 */
function to_title_case(string $string): string
{
  $tokens = preg_split('/[^a-zA-Z0-9]/', $string);
  $output = '';

  foreach ($tokens as $i => $token)
  {
    $output .= ucfirst(strtolower($token));
  }

  return $output;
}