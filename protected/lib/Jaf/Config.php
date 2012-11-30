<?php

class Jaf_Config {
  /**
   * Supported configuration types
   * @var array
   */
  protected  $_types = array('ini');

  /**
   * Actual config data
   * @var array
   */
  protected $_data = array();

  /**
   * @param mixed $data
   * @param string $environment
   * @param string $type
   * @throws Jaf_Exception
   */
  public function __construct($data, $environment, $type = 'ini') {
    $environment = (string) $environment;

    if (!in_array($type, $this->_types)) {
      throw new Jaf_Exception('Unregistered config type');
    }

    $rawConfig = array();

    switch($type) {
      case 'ini':
        $rawConfig = parse_ini_file($data, TRUE);
        break;
    }

    $preConfig = array();

    //sort raw config elements
    uksort($rawConfig, function($a, $b) {
      $ah = (bool) strpos($a, ':');
      $bh = (bool) strpos($b, ':');

      return $ah === $bh ? 0 : ($ah && !$bh ? 1 : -1);
    });

    //filter the keys
    foreach($rawConfig as $key => $value) {
      $_key = str_replace(' ', '', $key);

      if ($_key !== $key) {
        unset($rawConfig[$key]);
        $rawConfig[$_key] = $value;
      }
    }

    //fill the preConfig array && merge with possible per environment configuration options
    foreach($rawConfig as $key => $value) {
      if (!strpos($key, ':')) {
        $preConfig[$key] = $value;

        if (isset($rawConfig[$environment . ':' .$key])) {
          $preConfig[$key] = array_merge($preConfig[$key], $rawConfig[$environment . ':' .$key]);
        }
      }
    }

    //explode array
    $config = array();
    foreach($preConfig as $sKey => $sValue) {
      $config[$sKey] = array();

      foreach($sValue as $key => $value) {
        $parts = explode('.', $key);

        if (count($parts) == 1) {
          $config[$sKey][$key] = $value;
        }
        else {
          $link = &$config[$sKey];

          foreach($parts as $pValue) {
            if (!isset($link[$pValue])) {
              $link[$pValue] = array();
            }
            $link = &$link[$pValue];
          }

          $link = $value;
        }
      }
    }

    $this->_data = $config;
  }

  /**
   * Get the value from config object
   *
   * @param string $name
   * @param mixed $default
   * @param string $section
   * @return mixed
   */
  public function get($name, $default = NULL, $section = 'default') {
    $section = (string) $section;
    $name = (string) $name;

    return isset($this->_data[$section][$name]) ? $this->_data[$section][$name] : $default;
  }
}