<?php
spl_autoload_register(function ($classname) {
//    echo $classname;
    //Can't use __DIR__ as it's only in PHP 5.3+
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.strtolower($classname).'.php';
//    echo $filename;
    if (is_readable($filename)) {
        require $filename;
    }
});