<?php

namespace Giantpeach\Schnapps\Config\Facades;

use Giantpeach\Schnapps\Config\Config as ConfigInstance;

class Config
{
  public static function __callStatic($name, $arguments)
  {
    return call_user_func_array([ConfigInstance::getInstance(), $name], $arguments);
  }
}
