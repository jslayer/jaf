<?php

class Jaf_Request {
  protected $_controller;
  protected $_action;
  protected $_params = array();
  protected $_method;

  protected $_availMethods = array(
    'get', 'post'
  );

  public function __construct() {
    print_r($_SERVER);
  }

  protected function _setMethod($method) {
    $method = strtolower((string) $method);

    if (!in_array($method, $this->_availMethods)) {

    }
  }
}