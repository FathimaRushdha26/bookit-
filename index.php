<?php
// Front controller - every request enters here
session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/helpers.php';

spl_autoload_register(function ($class) {
    foreach (['core', 'controllers', 'models'] as $dir) {
        $file = __DIR__ . "/$dir/$class.php";
        if (file_exists($file)) { require_once $file; return; }
    }
});

new App();
