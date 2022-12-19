<?php

require "Validator.php";

$config = require "config.php";

if ($config['environment'] === 'development') {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

set_exception_handler(function (Exception $e) use ($config) {
    date_default_timezone_set($config['system']['timeZone']);

    $time = date($config['system']['timeFormat']);

    $message = "[{$time}] {$e->getMessage()}\n";

    // вот тут мы отправляем перехваченное исключение в другую систему
    //error_log($message, 3, 'logs/errors.log');

    require "views/error.view.php";
});