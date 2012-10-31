<?php
/**
 * Bootstrap the library.
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader;

require_once __DIR__ . '/Core/Autoloader.php';

$autoloader = new Core\AutoLoader(__NAMESPACE__, dirname(__DIR__));

$autoloader->register();

require_once __DIR__ . '/Security/password_compat.php';