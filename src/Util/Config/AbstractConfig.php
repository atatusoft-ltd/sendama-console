<?php

namespace Sendama\Console\Util\Config;

use RuntimeException;
use Sendama\Console\Util\Config\Interfaces\ConfigInterface;
use Sendama\Console\Util\Path;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractConfig implements ConfigInterface
{
  /**
   * AbstractConfig constructor.
   *
   * @param OutputInterface $output The output interface.
   */
  protected array $config = [];

  /**
   * The filename.
   *
   * @var string
   */
  protected string $filename = '';

  /**
   * AbstractConfig constructor.
   *
   * @param OutputInterface $output The output interface.
   */
  public function __construct(
    protected InputInterface $input,
    protected OutputInterface $output
  )
  {
    $this->load();
  }

  /**
   * @inheritDoc
   */
  public function get(string $path): mixed
  {
    $config = $this->config;
    $path = explode('.', $path);

    foreach ($path as $key) {
      if (isset($config[$key])) {
        $config = $config[$key];
      } else {
        return null;
      }
    }

    return $config;
  }

  /**
   * @inheritDoc
   */
  public function set(string $path, mixed $value): void
  {
    $config = &$this->config;
    $path = explode('.', $path);
    foreach ($path as $key) {
      if (! isset($config[$key])) {
        $config[$key] = [];
      }
      $config = &$config[$key];
    }
    $config = $value;
  }

  /**
   * @inheritDoc
   */
  public function load(): self
  {
    $filepath = Path::join(getcwd() ?: '', $this->filename);

    if (! file_exists($filepath) ) {
      throw new RuntimeException("$this->filename file not found.");
    }

    $this->config = json_decode(file_get_contents($filepath) ?: throw new RuntimeException("Failed to get contents of $this->filename"), true);

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function commit(): int|false
  {
    if (empty($this->filename)) {
      $this->output->writeln('No filename specified.');
      return false;
    }

    if (! file_exists($this->filename)) {
      $this->output->writeln('File not found.');
      return false;
    }

    $bytes = file_put_contents($this->filename, json_encode($this->config, JSON_PRETTY_PRINT));

    if ($bytes === false) {
      $this->output->writeln('Failed to write to file.');
      return false;
    }

    return $bytes;
  }
}