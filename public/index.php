<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../'));
define('STATIC_PATH','/statics');

$application = new Yaf_Application( APPLICATION_PATH . '/conf/application.ini');

$application->bootstrap()->run();
?>
