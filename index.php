<?php
/**
 * Almira Trans
 */
namespace Pentagonal\Project\AlmiraTrans {
    error_reporting(~1);
    ini_set('display_errors', 1);
    register_shutdown_function(function () {
        print_r(error_get_last());
    });
    require_once __DIR__ . '/vendor/autoload.php';
    $app = new Application();
    $app->run();
}
