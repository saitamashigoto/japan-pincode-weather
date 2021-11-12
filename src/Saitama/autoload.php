<?php

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new Exception('This Application requires PHP version 5.4 or higher.');
}

spl_autoload_register(function ($class) {
    $prefix = 'Saitama\\';

    $baseDir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = rtrim($baseDir, '/') . '/' . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
