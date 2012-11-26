<?php
class Jaf_Application {
  protected $_env;

  /**
   * Initialize an application
   * @param string $environment
   * @param Jaf_Config $config
   */
  public function __construct($environment, $config) {
    $this->_env = $environment;
  }

  public function bootstrap() {

  }

  public function run() {

  }
}