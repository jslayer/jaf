<?php

class Jaf_Request {
  const GET  = 'GET';
  const POST = 'POST';

  protected $_controller;
  protected $_action;
  protected $_params = array();

  protected static $defaultController = 'index';
  protected static $defaultAction     = 'index';

  public function __construct() {
    $parts = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : array();

    $this->_controller = !empty($parts[0]) ? array_shift($parts) : self::$defaultController;

    $this->_action = !empty($parts[0]) ? array_shift($parts) : self::$defaultAction;

    while(count($parts) > 1) {
      $key = array_shift($parts);
      $value = array_shift($parts);

      if ($key && $value) {
        $this->setParam($key, $value);
      }
    }
  }

  /**
   * Return request method
   * @return string
   */
  public function getMethod() {
    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Get param
   * @param string $name
   * @param mixed $default
   * @return mixed
   */
  public function getParam($name, $default) {
    $name = (string) $name;
    if (isset($this->_params[$name])) {
      return $this->_params[$name];
    } elseif(isset($_GET[$name])) {
      return $_GET[$name];
    } elseif(isset($_POST[$name])) {
      return $_POST[$name];
    }

    return $default;
  }

  /**
   * Set param
   * @param string $name
   * @param mixed $value
   */
  public function setParam($name, $value) {
    $this->_params[$name] = $value;
  }

  /**
   * Check isXmlHttpRequest
   * @return bool
   */
  public function isXHR(){
    return ($_SERVER['X_REQUESTED_WITH'] == 'XMLHttpRequest');
  }

  /**
   * Return raw body
   * @return string
   */
  public function getRawBody() {
    static $rawBody;

    if (NULL === $rawBody) {
      $rawBody = file_get_contents('php://input');
    }
    return $rawBody;
  }

  /**
   * Set default controller string
   * @param string $value
   * @return Jaf_Request
   */
  public static function setDefaultController($value) {
    self::$defaultController = (string) $value;
  }

  /**
   * Return controller name
   * @return string
   */
  public function getControllerName() {
    return $this->_controller;
  }

  /**
   * Return action name
   * @return string
   */
  public function getActionName() {
    return $this->_action;
  }

  /**
   * Set default action string
   * @param string $value
   * @return Jaf_Request
   */
  public static function setDefaultAction($value) {
    self::$defaultAction = (string) $value;
  }
}