<?php

function autoloader($className) {
    $classFile = __DIR__ . '/../src/model/' . $className . '.php';
    if (file_exists($classFile)) {
        require_once($classFile);
    }
}

spl_autoload_register('autoloader');

?>