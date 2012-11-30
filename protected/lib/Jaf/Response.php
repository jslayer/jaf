<?php
/**
 * Jaf_Response class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_Response
 */

/**
 * Jaf_Response maintain the request headers & body
 *
 * @class Jaf_Response
 */
class Jaf_Response {
  /**
   * Response body
   *
   * @var string
   */
  protected $_body;

  /**
   * Uses in header generation while response dispatch
   *
   * @var string
   */
  protected $_contentType = 'text/html';

  /**
   * Set the request body
   *
   * @param mixed $data
   * @return Jaf_Response
   */
  public function setBody($data) {
    $this->_body = $data;
    return $this;
  }

  /**
   * Dispatch the response. Send data to the client
   */
  public function dispatch() {
    header('Content-Type: ' . $this->_contentType);

    print $this->_body;
  }
}