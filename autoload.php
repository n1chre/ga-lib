<?php

$base = __DIR__ . "/";

// register my autoloader
$my_autoload = function ($classname) use ($base) {
    $fileName = $base . str_replace("\\", "/", $classname) . ".php";
    if (!is_readable($fileName)) return false;
    require_once $fileName;
    return true;
};
spl_autoload_register($my_autoload);
