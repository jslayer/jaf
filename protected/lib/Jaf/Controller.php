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

  public final function __construct(Jaf_Request $request, Jaf_Response $response) {
    $this->_request = $request;

    $this->_response = $response;
  }

  public function dispatch() {
    $this->{$this->_defaultAction}();
  }

  /**
   * @param $name
   * @return Jaf_Controller
   */
  public function setAction($name) {
    $this->_defaultAction = (string) $name;
    return $this;
  }

  public function getAction() {
    return $this->_defaultAction;
  }
}