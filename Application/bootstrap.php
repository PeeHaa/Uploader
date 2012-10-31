<?php
/**
 * Bootstrap the application
 *
 * PHP version 5.4
 *
 * @category   Application
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application;

use RichUploader\Core\Autoloader,
    RichUploader\Upload\Uploader,
    RichUploader\Security\CsrfToken,
    RichUploader\Security\CsrfToken\StorageMedium\Session as CsrfSession,
    RichUploader\Storage\Session;

/**
 * set up the limits for the upload process
 */
ini_set('memory_limit', '-1');
set_time_limit (6000);

/**
 * load the environment
 */
require 'init-deployment.php';

/**
 * setup autoloader for the application
 */
$autoloader = new AutoLoader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();

/**
 * start the session
 */
session_start();
$session = new Session();

/**
 * setup the CSRF token
 */
$csrfToken = new CsrfToken(new CsrfSession('csrf_token', $session));

/**
 * setup the router
 */
switch (true) {
    case preg_match('/^(\/?login-popup\/?)$/', $_SERVER['REQUEST_URI']):
        $view       = new \Application\Views\User\LoginPopup($csrfToken);
        $controller = new \Application\Controllers\User();
        $response   = $controller->loginPopup($view);
        break;

    case preg_match('/^(\/?login\/?)$/', $_SERVER['REQUEST_URI']):
        $model      = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\User\Login($model, $csrfToken);
        $controller = new \Application\Controllers\User();
        $response   = $controller->login($view, $_POST);
        break;

    case preg_match('/^(\/?upload\/)/', $_SERVER['REQUEST_URI']):
        $pathParts = explode('/', $_SERVER['REQUEST_URI']);

        $richUploader = new Uploader(end($pathParts));
        echo json_encode($richUploader->handleUpload('../data/'));
        break;

    default:
        $model      = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\Frontpage\Index($model);
        $controller = new \Application\Controllers\Index();
        $response   = $controller->frontpage($view);
        break;
}

/**
 * display the output
 */
echo $response->render();