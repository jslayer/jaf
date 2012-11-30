<?php
class Jaf_View {

  /**
   * @var array
   */
  protected $_data = array();

  protected $_viewsPath;

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
   * @param string $name
   * @param null|mixed $default
   * @return array|null
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