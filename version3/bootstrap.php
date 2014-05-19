<?php
define('DS', DIRECTORY_SEPARATOR);
define('APPPATH', __DIR__ . DS);
require_once 'packages/autoloader.php';

Autoloader::register();

Session::start();
