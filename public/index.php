<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../'));
define('APP_PATH', realpath(dirname(__FILE__).'/../application/'));
define('UPLOAD_PATH',APPLICATION_PATH.'/public/statics/uploads/');
define('STATIC_PATH','/statics');

$application = new Yaf_Application( APPLICATION_PATH . '/conf/application.ini');
$application->bootstrap()->run();
?>
