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

  /**
   * @var Jaf_Request
   */
  protected $_request;

  /**
   * @var Jaf_Response
   */
  protected $_response;

  /**
   * @var Jaf_View
   */
  protected $_view;

  /**
   * @var Jaf_Config
   */
  protected $_config;

  /**
   * @var Jaf_Controller
   */
  protected $_controller;

  protected $_directories = array(
    'controllers' => 'controllers',
    'models'      => 'models',
    'views'       => 'views'
  );

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

    $this->_configuration();

    $this->_parseRequest();

    $this->_prepareResponse();
  }

  /**
   * Process configuration
   */
  protected function _configuration() {
    $defaultController = $this->_config->get('defaultController');

    if ($defaultController) {
      Jaf_Request::setDefaultController($defaultController);
    }

    $defaultAction = $this->_config->get('defaultAction');

    if ($defaultAction) {
      Jaf_Request::setDefaultAction($defaultAction);
    }
  }

  public function run() {
    $actionName = $this->_request->getActionName();

    //prepare controller name
    $controllerClass = ucfirst($this->_request->getControllerName()) . 'Controller';
    $actionMethod = lcfirst($actionName) . 'Action';

    $this->_controller = new $controllerClass($this->_request, $this->_response);

    //check method existence
    if (!method_exists($this->_controller, $actionMethod)) {
      throw new Jaf_Exception('Could not found '. $actionMethod .' method of '. $controllerClass);
    }

    $this->_controller->setAction($actionMethod);

    //Actual controller dispatch execution
    $this->_controller->dispatch();
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

  protected function _prepareResponse() {
    $this->_response = new Jaf_Response();
  }

  /**
   * Get the current front controller instance
   * @return Jaf_Controller
   * @throws Jaf_Exception
   */
  /*public static function front() {
    if (!self::$_front instanceof Jaf_Controller) {
      throw new Jaf_Exception('Front controller not initialized yet');
    }

    return self::$_front;
  }*/
}