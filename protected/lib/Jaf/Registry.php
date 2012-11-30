<?php
/**
 * Jaf_Registry class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_Registry
 */

/**
 * Base registry class
 *
 * @class Jaf_Registry
 */
class Jaf_Registry {
  /**
   * Registry data
   *
   * @var array
   */
  protected $_data = array();

  /**
   * Registry singleton factory
   *
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
   *
   * @param string $name
   * @param mixed $value
   */
  public static function set($name, $value) {
    $inst = self::instance();

    $inst->_data[$name] = $value;
  }

  /**
   * Registry static getter
   *
   * @param string $name
   * @return mixed
   */
  public static function get($name) {
    $inst = self::instance();

    return isset($inst->_data[$name]) ? $inst->_data[$name] : NULL;
  }
}