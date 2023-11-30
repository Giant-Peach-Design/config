<?php

namespace Giantpeach\Schnapps\Config\Cli;

class Cli
{

  public function __construct()
  {
    add_action('cli_init', [$this, 'registerCommands']);
  }

  public function registerCommands()
  {
    \WP_CLI::add_command('clear-cache', [$this, 'clearCache']);
  }

  public function clearCache()
  {
    $cachePath = \get_template_directory() . '/cache';

    if (file_exists($cachePath)) {
      $this->deleteDirectory($cachePath);
    }

    \WP_CLI::success('Cache cleared');
  }

  private function deleteDirectory($dir)
  {
    if (!file_exists($dir)) {
      return true;
    }

    if (!is_dir($dir)) {
      return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
      if ($item == '.' || $item == '..') {
        continue;
      }

      if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
        return false;
      }
    }

    return rmdir($dir);
  }
}
