<?php
class Jaf_Response {
  protected $_body;

  protected $_contentType = 'text/html';

  /**
   * @param mixed $data
   * @return Jaf_Response
   */
  public function setBody($data) {
    $this->_body = $data;
    return $this;
  }

  /**
   * Dispatch the response
   * Send data to the client
   */
  public function dispatch() {
    header('Content-Type: ' . $this->_contentType);

    print $this->_body;
  }
}