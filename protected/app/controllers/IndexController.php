<?php
class IndexController extends Jaf_Controller {
  public function indexAction() {
    $this->view->set('html.title', 'Sample application page');
  }
}