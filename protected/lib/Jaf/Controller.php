<?php
/**
 * Jaf_Controller class file.
 *
 * @author    Eugene Poltorakov <jslayer@gmail.com>
 * @license   http://opensource.org/licenses/mit-license.php
 * @version   $Id$
 * @category  Jaf
 * @package   Jaf_Controller
 */

/**
 * Base controller class
 *
 * @class Jaf_Controller
 */
class Jaf_Controller {
  /**
   * Default action string
   *
   * @var string
   */
  protected $_defaultAction = 'indexAction';

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
  public $view;

  //public final function __construct() {}

  /**
   * Dispatch the controller
   */
  public function dispatch() {
    //call initialize method
    $this->initialize();

    //call an actual action method
    $this->{$this->_defaultAction}();

    //call destructor method
    $this->destructor();
  }

  /**
   * Set the request object
   *
   * @param Jaf_Request $request
   * @return Jaf_Controller
   */
  public function setRequest(Jaf_Request $request) {
    $this->_request = $request;
    return $this;
  }

  /**
   * Set the response object
   *
   * @param Jaf_Response $response
   * @return Jaf_Controller
   */
  public function setResponse(Jaf_Response $response) {
    $this->_response = $response;
    return $this;
  }

  /**
   * Return request object
   *
   * @return Jaf_Request
   */
  public function getRequest() {
    return $this->_request;
  }

  /**
   * Return response object
   *
   * @return Jaf_Response
   */
  public function getResponse() {
    return $this->_response;
  }

  /**
   * Set default action string
   *
   * @param $name
   * @return Jaf_Controller
   */
  public function setAction($name) {
    $this->_defaultAction = (string) $name;
    return $this;
  }

  /**
   * Get default action string
   *
   * @return string
   */
  public function getAction() {
    return $this->_defaultAction;
  }

  /**
   * Override this in your controllers
   * This method is executed before the action
   */
  protected function initialize() {}

  /**
   * Override this in your controllers
   * This method is executed after the action
   */
  protected function destructor() {}
}