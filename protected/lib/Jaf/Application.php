<?php
class Jaf_Application {
  /**
   * @var Jaf_Controller
   */
  protected static $_front;

  /**
   * @var string
   */
  protected $_environment;

  protected $_request;

  protected $_response;

  /**
   * @var Jaf_Config
   */
  protected $_config;

  protected $_directories = array(
    'controllers' => 'controllers',
    'models'      => 'models'
  );

  protected $_defaultController = 'index';
  protected $_defaultAction     = 'index';

  protected $_appPath;

  /**
   * Initialize an application
   * @param string $environment
   * @param string $appPath
   * @param Jaf_Config $config
   * @throws Jaf_Exception
   */
  public function __construct($environment, $appPath,  Jaf_Config $config) {
    if (!is_dir($appPath)) {
      throw new Jaf_Exception('appPath is not a directory');
    }

    $this->_environment = (string) $environment;

    $this->_appPath = (string) $appPath;

    $this->_loader = Jaf_Loader::instance();

    $this->_config = $config;

    //save config in registry
    Jaf_Registry::set('config', $config);

    $this->_setupLoader();

    $this->_parseRequest();
  }

  /*public function bootstrap() {

  }*/

  public function run() {

  }

  /**
   * Add controllers, models directory path to loader include paths
   */
  protected function _setupLoader() {
    $dirs = array();

    foreach($this->_directories as $dir) {
      array_push($dirs, $this->_appPath . '/' . $dir);
    }

    $this->_loader->addIncludePath($dirs);
  }

  protected function _parseRequest() {
    $this->_request = new Jaf_Request();
  }

  /**
   * Get the current front controller instance
   * @return Jaf_Controller
   * @throws Jaf_Exception
   */
  public static function front() {
    if (!self::$_front instanceof Jaf_Controller) {
      throw new Jaf_Exception('Front controller not initialized yet');
    }

    return self::$_front;
  }
}