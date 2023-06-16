<?php 

function autoloader($className) {
    $classfile = __DIR__ . '/../src/model/' . $className . '.php';
    if(file_exists($classfile)) {
        require_once($classfile);
    }
}

//PHP natif : spl _autoload_register
spl_autoload_register('autoloader');

?>