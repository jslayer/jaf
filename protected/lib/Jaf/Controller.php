<?php

class Jaf_Controller {
  /**
   * @var string
   */
  protected $_defaultAction = 'indexAction';

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
  public $view;

  //public final function __construct() {}

  public function dispatch() {
    //call initialize method
    $this->initialize();

    //call an actual action method
    $this->{$this->_defaultAction}();

    //call destructor method
    $this->destructor();
  }

  /**
   * @param Jaf_Request $request
   * @return Jaf_Controller
   */
  public function setRequest(Jaf_Request $request) {
    $this->_request = $request;
    return $this;
  }

  /**
   * @param Jaf_Response $response
   * @return Jaf_Controller
   */
  public function setResponse(Jaf_Response $response) {
    $this->_response = $response;
    return $this;
  }

  /**
   * @return Jaf_Request
   */
  public function getRequest() {
    return $this->_request;
  }

  /**
   * @return Jaf_Response
   */
  public function getResponse() {
    return $this->_response;
  }

  /**
   * @param $name
   * @return Jaf_Controller
   */
  public function setAction($name) {
    $this->_defaultAction = (string) $name;
    return $this;
  }

  /**
   * @return string
   */
  public function getAction() {
    return $this->_defaultAction;
  }

  protected function initialize() {}

  protected function destructor() {}
}