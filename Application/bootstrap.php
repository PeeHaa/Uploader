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
    RichUploader\Http\Request,
    RichUploader\Http\RequestMatcher,
    RichUploader\Http\RequestMatcher\Factory as RequestMatcherFactory,
    RichUploader\Upload\Uploader,
    RichUploader\Security\CsrfToken,
    RichUploader\Security\CsrfToken\StorageMedium\Session as CsrfSession,
    RichUploader\Storage\Session,
    RichUploader\Acl\Verifier;

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
 * setup the request object
 */
$request = new Request($_SERVER, $_GET, $_POST);

/**
 * Load the roles of the system
 */
require 'roles.php';

/**
 * setup ACL
 */
$acl = new Verifier($session);
$acl->addRoles($roles);

/**
 * setup the router
 */
require 'routes.php';
$requestMatcherFactory = new RequestMatcherFactory($request, $acl);
$requestMatcher = new RequestMatcher($requestMatcherFactory);

switch (true) {
    case $requestMatcher->doesMatch($routes['user/login']['requirements']):
        $model      = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\User\Login($model, $csrfToken);
        $controller = new \Application\Controllers\User();
        $response   = $controller->login($view, $request);
        break;

    case $requestMatcher->doesMatch($routes['user/login/popup']['requirements']):
        $view       = new \Application\Views\User\LoginPopup($csrfToken);
        $controller = new \Application\Controllers\User();
        $response   = $controller->loginPopup($view);
        break;

    case $requestMatcher->doesMatch($routes['user/logout']['requirements']):
        $request->setPathVariables($routes['user/logout']['mapping']);

        $userModel  = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\User\Logout($userModel, $csrfToken);
        $controller = new \Application\Controllers\User();
        $response   = $controller->logout($view, $request);
        break;

    case $requestMatcher->doesMatch($routes['user/settings']['requirements']):
        $userModel    = new \Application\Models\User($dbConnection, $session);
        $settingModel = new \Application\Models\Setting($dbConnection);
        $view         = new \Application\Views\User\SettingsOverview($userModel, $settingModel);
        $controller   = new \Application\Controllers\Setting();
        $response     = $controller->overview($view);
        break;

    case $requestMatcher->doesMatch($routes['upload']['requirements']):
        $userModel    = new \Application\Models\User($dbConnection, $session);
        $fileFactory  = new \RichUploader\FileSystem\FileFactory();
        $uploadModel  = new \Application\Models\Upload($dbConnection, $userModel, $fileFactory, __DIR__ . '/data');
        $view         = new \Application\Views\Upload\Result();
        $richUploader = new Uploader($request);
        $controller   = new \Application\Controllers\Upload($richUploader, $uploadModel, $request);
        $response     = $controller->process($view);
        break;

    case $requestMatcher->doesMatch($routes['index/frontpage']['requirements']):
        $userModel  = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\Frontpage\Index($userModel, $csrfToken);
        $controller = new \Application\Controllers\Index();
        $response   = $controller->frontpage($view);
        break;

    case $requestMatcher->doesMatch($routes['upload']['requirements']):
        $userModel  = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\Frontpage\Index($userModel, $csrfToken);
        $controller = new \Application\Controllers\Index();
        $response   = $controller->frontpage($view);
        break;

    default:
        // 404
        break;
}

/**
 * display the output
 */
echo $response->render();