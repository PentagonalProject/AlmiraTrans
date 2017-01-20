<?php
/**
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * -     _____  ____  ______  ___  ______  _____  ____  ______ ______   ___    -
 * -    /  __ \/ __ \/  __  \/  /_ \___  \/ __  \/ __ \/  __  \\___  \ /  /    -
 * -    / /_/ /  ___/  / /  /  __//  _   / /_/  / /_/ /  / /  /  _   //  /     -
 * -   /  .__/\____/\_/ /__/\____/\___._/\__   /\____/\_/ /__/\___._//  /      -
 * -  /  /  _________________________  ____/  /                     /  /____   -
 * - /__/  \________________________/ /______/                     ._______/   -
 * -                                                                           -
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

/**
 * Almira Trans
 */
namespace PentagonalProject\AlmiraTrans {
    error_reporting(~0);
    date_default_timezone_set('GMT+7');

    if (function_exists('ini_set')) {
        ini_set('display_errors', 1);
        ini_set('log_errors', 0);
    }

    require_once __DIR__ . '/vendor/autoload.php';
    $app = new Application();
    $app->run();
}
