<?php

namespace Giantpeach\Schnapps\Config\Composer;

use Composer\Script\Event;

class ScriptHandler
{
  public static function updateConfig(Event $event)
  {
    $path = \getcwd();
    $event->getIO()->write('Locating config cache...');

    $path .= '/web/app/themes/schnapps';

    $cachePath = $path . '/cache';

    if (file_exists($cachePath)) {
      $event->getIO()->write('Clearing config cache...');
      $self = new self();
      $self->deleteDirectory($cachePath);
      $event->getIO()->write('Config cache cleared.');
    } else {
      $event->getIO()->write('Config cache not found. Skipping.');
    }
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
