<?php

namespace Giantpeach\Schnapps\Config;

class Loader
{
  private string $themePath = '';
  private string $configFolder = 'src/Config';
  private string $cacheFolder = 'cache';

  public function __construct()
  {
    $this->themePath = get_template_directory();
  }

  public function load()
  {
    return $this->loadConfigFiles();
  }

  /**
   * Load config files from cache if available, otherwise load from config folder
   *
   * @return void
   */
  private function loadConfigFiles(): array
  {
    if (file_exists($this->themePath . '/' . $this->cacheFolder . '/config.php')) {
      $config = require $this->themePath . '/' . $this->cacheFolder . '/config.php';

      return $config;
    }

    $configPath = $this->themePath . '/' . $this->configFolder;
    $configFiles = glob($configPath . '/*.php');
    $configData = [];

    foreach ($configFiles as $configFile) {
      $config = require $configFile;

      $configName = basename($configFile, '.php');

      $configData[$configName] = $config;
    }

    $this->cacheConfig($configData);

    return $configData;
  }

  /**
   * Cache config files
   *
   * @param array $config Config data to cache
   * @return void
   */
  private function cacheConfig(array $config): void
  {
    $cachePath = $this->themePath . '/' . $this->cacheFolder;

    if (!file_exists($cachePath)) {
      mkdir($cachePath);
    }

    $cacheFile = $cachePath . '/config.php';

    file_put_contents($cacheFile, '<?php return ' . var_export($config, true) . ';');
  }
}
