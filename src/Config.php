<?php

namespace Giantpeach\Schnapps\Config;

class Config
{
  private static $instance = null;

  protected array $config = [];

  public static function getInstance(): Config
  {
    if (self::$instance === null) {
      self::$instance = new Config();
    }

    return self::$instance;
  }

  public function load()
  {
    $loader = new Loader();
    $configData = $loader->load();

    $this->config = $configData;
  }

  public function get(string $key)
  {
    // handle nested keys
    if (strpos($key, '.') !== false) {
      $keys = explode('.', $key);

      $config = $this->config;

      foreach ($keys as $key) {
        $config = $config[$key] ?? null;
      }

      return $config;
    }

    return $this->config[$key] ?? null;
  }

  public function set(string $key, $value): void
  {
    $this->config[$key] = $value;
  }
}