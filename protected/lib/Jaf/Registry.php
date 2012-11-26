<?php
class Jaf_Registry {
  private $_data = array();

  public function __construct() {}

  /**
   * Registry singleton factory
   * @return Jaf_Registry
   */
  public static function instance() {
    static $inst = FALSE;

    if (!$inst) {
      $inst = new self;
    }

    return $inst;
  }

  /**
   * Registry static setter
   * @param string $name
   * @param mixed $value
   */
  public static function set($name, $value) {
    $inst = self::instance();

    $inst->_data[$name] = $value;
  }

  /**
   * @param string $name
   * @return mixed
   */
  public static function get($name) {
    $inst = self::instance();

    return isset($inst->_data[$name]) ? $inst->_data[$name] : null;
  }
}