<?php
/**
 * Almira Trans
 */
namespace PentagonalProject\AlmiraTrans {
    error_reporting(0);
    date_default_timezone_set('GMT+7');

    if (function_exists('ini_set')) {
        ini_set('display_errors', 0);
        ini_set('log_errors', 0);
    }

    require_once __DIR__ . '/vendor/autoload.php';
    $app = new Application();
    $app->run();
}
