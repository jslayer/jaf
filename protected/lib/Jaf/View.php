<?php
/**
 * Jaf_View class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_View
 */

/**
 * Base view class
 *
 * @class Jaf_View
 */
class Jaf_View {

  /**
   * Actual view data storage array
   *
   * @var array
   */
  protected $_data = array();

  /**
   * Path to the app views scripts
   * Default is : APP_PATH/views
   *
   * @var string
   */
  protected $_viewsPath;

  /**
   * View constructor
   *
   * @param array $data
   * @param string $viewsPath
   * @throws Jaf_Exception
   */
  public function __construct($data, $viewsPath) {
    if (is_array($data)) {
      $this->_data = $data;
    }

    if (!is_dir($viewsPath)) {
      throw new Jaf_Exception('appPath is incorrect');
    }

    $this->_viewsPath = (string) $viewsPath;
  }

  /**
   * Get view data
   *
   * Examples:
   * View->get('foo')
   * View->get('foo.bar')
   *
   * @param string $name
   * @param null|mixed $default
   * @return mixed|null
   */
  public function get($name, $default = NULL) {
    $value = &$this->_data;

    $parts = explode('.', $name);

    while($key = array_shift($parts)) {
      if (isset($value[$key])) {
        $value = &$value[$key];
      }
      else {
        $value = $default;
        break;
      }
    }

    return $value;
  }

  /**
   * Set view data
   *
   * Examples:
   * View->set('foo', 'Hello')
   * View->set('foo.bar', array('hello' => 'world'))
   *
   * @param string $name
   * @param mixed $value
   * @return Jaf_View
   */
  public function set($name, $value) {
    $link = &$this->_data;

    $parts = explode('.', $name);

    while($key = array_shift($parts)) {
      if (!isset($link[$key])) {
        $link[$key] = array();

        $link = &$link[$key];
      }
    }

    $link = $value;

    return $this;
  }

  /**
   * Render view script
   *
   * @param $script
   * @throws Jaf_Exception
   * @internal param string $path
   * @return string
   */
  public function render($script) {
    $path = $this->_viewsPath . '/' .$script . '.phtml';

    if (!file_exists($path)) {
      throw new Jaf_Exception($path . 'view file not exists');
    }
    ob_start();
    include($path);
    return ob_get_clean();
  }
}