<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//TODO: сложный пример, заменить его на простую проверку автозагрузчика Composer vendor/autoload и include файлов
spl_autoload_register(function ($className) {
    $className = explode('\\', $className);
    $className =  end($className);
    $filename = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $className . '.php';

    if (is_readable($filename)) {
        require_once($filename);
    }
});

require 'example.php';
