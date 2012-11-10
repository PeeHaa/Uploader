<?php
/**
 * Bootstrap the tests. This enables autoloading of mock classes and the library. It also provides a (global) function
 * to be able to load data.
 *
 * PHP version 5.4
 *
 * @category   RichUploaderTest
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploaderTest;

ini_set('memory_limit', '1G');

/**
 * The simple autoloader for the PasswordLibTest libraries.
 *
 * This does not use the PRS-0 standards due to the namespace prefix and directory
 * structure
 *
 * @param string $class The class name to load
 *
 * @return void
 */
spl_autoload_register(function ($class) {
    $nslen = strlen(__NAMESPACE__);
    if (substr($class, 0, $nslen) != __NAMESPACE__) {
        //Only autoload libraries from this package
        return;
    }
    $path = substr(str_replace('\\', '/', $class), $nslen);
    $path = __DIR__ . $path . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

define('PATH_ROOT', dirname(__DIR__));

function getTestDataFromFile($file) {
    return require __DIR__ . '/Data/' . $file;
}

require_once dirname(__DIR__) . '/src/RichUploader/bootstrap.php';