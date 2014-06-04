<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

$loader = require(dirname(__FILE__) . '/vendor/autoload.php');
$loader->add('FinderTest\\', __DIR__ . '/src'); 

