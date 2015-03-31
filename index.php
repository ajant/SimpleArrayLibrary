<?php
require 'vendor/autoload.php';
use SimpleArrayLibrary\SimpleArrayLibrary;

var_dump(SimpleArrayLibrary::castColumns(array(array('a' => '2')), array('a' => SimpleArrayLibrary::TYPE_INT)));
var_dump(SimpleArrayLibrary::castColumns(array(array()), array('a' => SimpleArrayLibrary::TYPE_INT), false));
var_dump(SimpleArrayLibrary::castColumns(array(array('a' => '1'), array('b' => 'foo')), array('a' => SimpleArrayLibrary::TYPE_INT), false));