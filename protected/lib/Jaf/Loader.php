<?php
class Jaf_Loader {
  public function __construct() {
    spl_autoload_register(array($this, '_loader'));
  }

  /**
   * Singleton
   * Return instance of Loader class
   * @return Loader
   */
  public static function instance() {
    static $inst = FALSE;

    if (!$inst) {
      $inst = new self();
    }

    return $inst;
  }

  private function _loader($className) {
    include str_replace('_', '/', $className) . '.php';
  }

  /**
   * Add include path (php.include_path)
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