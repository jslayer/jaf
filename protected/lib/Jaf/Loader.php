<?php
/**
 * Jaf_Loader class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_Loader
 */

/**
 * Base loader class
 *
 * @class Jaf_Loader
 */
class Jaf_Loader {
  /**
   * Jaf_Loader constructor
   */
  public function __construct() {
    spl_autoload_register(array($this, '_loader'));
  }

  /**
   * Return singleton instance of Loader class
   *
   * @return Jaf_Loader
   */
  public static function instance() {
    static $inst = FALSE;

    if (!$inst) {
      $inst = new self();
    }

    return $inst;
  }

  /**
   * Initialize Loader instance
   *
   * @return Jaf_Loader
   */
  public static function init() {
    return self::instance();
  }

  /**
   * Autoloader callback
   *
   * @param $className
   */
  private function _loader($className) {
    $className = (string) $className;
    include str_replace('_', '/', $className) . '.php';
  }

  /**
   * Add include path (php.include_path)
   *
   * @param [array|string] $path
   */
  public static function addIncludePath($path) {
    $paths = '';
    switch(gettype($path)) {
      case 'string':
        if(is_dir($path)) {
          $paths = $path;
        }
        break;
      case 'array':
        foreach($path as $k => $v) {
          if (!is_dir($v)) {
            unset($path[$k]);
          }
        }
        $paths = implode(':', $path);
        break;
    }

    if ($paths) {
      set_include_path(get_include_path() . ':' . $paths);
    }
  }
}