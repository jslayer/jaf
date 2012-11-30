<?php
/**
 * Jaf_Application class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_Application
 */

/**
 * Base application class
 *
 * @class Jaf_Application
 */
class Jaf_Application {

  /**
   * Environment string
   *
   * @var string
   */
  protected $_environment;

  /**
   * Request object
   *
   * @var Jaf_Request
   */
  protected $_request;

  /**
   * Response object
   *
   * @var Jaf_Response
   */
  protected $_response;

  /**
   * View object
   *
   * @var Jaf_View
   */
  protected $_view;

  /**
   * Config object
   *
   * @var Jaf_Config
   */
  protected $_config;

  /**
   * Controller object
   *
   * @var Jaf_Controller
   */
  protected $_controller;

  /**
   * List of included directories
   *
   * @var array
   */
  protected $_directories = array(
    'controllers' => 'controllers',
    'models'      => 'models'
  );

  /**
   * Default views path (relative to app path)
   *
   * @var string
   */
  protected $_viewsPath = 'views';

  /**
   * App path string
   *
   * @var string
   */
  protected $_appPath;

  /**
   * Initialize an application
   *
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
   *
   * @return Jaf_Application
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

  /**
   * Runs the application
   *
   * @throws Jaf_Exception
   * @return Jaf_Application
   */
  public function run() {
    $controllerName = $this->_request->getControllerName();
    $actionName = $this->_request->getActionName();

    //prepare controller name
    $controllerClass = ucfirst($controllerName) . 'Controller';
    $actionMethod = lcfirst($actionName) . 'Action';

    $this->_controller = new $controllerClass();

    //check method existence
    if (!method_exists($this->_controller, $actionMethod)) {
      throw new Jaf_Exception('Could not found '. $actionMethod .' method of '. $controllerClass);
    }

    $this->_controller->setAction($actionMethod);

    $this->_controller->setRequest($this->_request);

    $this->_controller->setResponse($this->_response);

    //initialize view
    $this->_view = new Jaf_View(Jaf_Registry::get('config')->get('view'), $this->_appPath . '/' . $this->_viewsPath);

    $this->_controller->view = $this->_view;

    //Actual controller dispatch execution
    $this->_controller->dispatch();

    $this->_response->setBody($this->_view->render(implode('/', array(
      $controllerName,
      $actionName
    ))));

    $this->_response->dispatch();
  }

  /**
   * Add controllers, models directory path to loader include paths
   *
   * @return Jaf_Application
   */
  protected function _setupLoader() {
    $dirs = array();

    foreach($this->_directories as $dir) {
      array_push($dirs, $this->_appPath . '/' . $dir);
    }

    $this->_loader->addIncludePath($dirs);

    return $this;
  }

  /**
   * Create request object
   *
   * @return Jaf_Application
   */
  protected function _parseRequest() {
    $this->_request = new Jaf_Request();
    return $this;
  }

  /**
   * Create response object
   *
   * @return Jaf_Application
   */
  protected function _prepareResponse() {
    $this->_response = new Jaf_Response();
    return $this;
  }
}