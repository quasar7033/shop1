<?php

/*
 * autoload for project components modela and controllers
 */

function __autoload($class_name){
    $array_path = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

    foreach ($array_path as $path) {
        $path = ROOT . $path . $class_name . '.php';
        if (is_file($path)){
            include_once $path;
        }
    }
}