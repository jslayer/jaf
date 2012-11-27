<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

defined('BASE_PATH') || define('BASE_PATH', realpath(dirname(__FILE__)));
defined('APP_PATH')  || define('APP_PATH', BASE_PATH . '/protected/app');
defined('APP_ENV')   || define('APP_ENV', 'develop');

require_once 'protected/lib/Jaf/Loader.php';

Jaf_Loader::addIncludePath(array(
  BASE_PATH . '/protected/lib/'
));

Jaf_Loader::init();

$config = new Jaf_Config(APP_PATH . '/configs/config.ini', APP_ENV);

$app = new Jaf_Application(APP_ENV, APP_PATH, $config);

$app->run();