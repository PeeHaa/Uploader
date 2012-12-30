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
    RichUploader\Acl\Verifier,
    RichUploader\FileSystem\FileFactory;

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
        $request->setPathVariables($routes['upload']['mapping']);

        $userModel    = new \Application\Models\User($dbConnection, $session);
        $fileFactory  = new \RichUploader\FileSystem\FileFactory();
        $uploadModel  = new \Application\Models\Upload($dbConnection, $userModel, $fileFactory, __DIR__ . '/data');
        $view         = new \Application\Views\Upload\Result();
        $richUploader = new Uploader($request);
        $controller   = new \Application\Controllers\Upload($richUploader, $uploadModel, $request);
        $response     = $controller->process($view);
        break;

    case $requestMatcher->doesMatch($routes['index/frontpage']['requirements']):
        $request->setPathVariables($routes['index/frontpage']['mapping']);

        $userModel  = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\Frontpage\Index($userModel, $csrfToken, $request);
        $controller = new \Application\Controllers\Index();
        $response   = $controller->frontpage($view);
        break;

    case $requestMatcher->doesMatch($routes['upload']['requirements']):
        $userModel  = new \Application\Models\User($dbConnection, $session);
        $view       = new \Application\Views\Frontpage\Index($userModel, $csrfToken);
        $controller = new \Application\Controllers\Index();
        $response   = $controller->frontpage($view);
        break;

    case $requestMatcher->doesMatch($routes['user/uploads']['requirements']):
        $request->setPathVariables($routes['user/uploads']['mapping']);

        $userModel  = new \Application\Models\User($dbConnection, $session);
        $fileModel  = new \Application\Models\File($dbConnection, $userModel,  __DIR__ . '/data');
        $view       = new \Application\Views\Files\Overview($userModel, $fileModel, $request, $csrfToken);
        $controller = new \Application\Controllers\File();
        $response   = $controller->overview($view);
        break;

    case $requestMatcher->doesMatch($routes['user/uploads/file/edit']['requirements']):
        $request->setPathVariables($routes['user/uploads/file/edit']['mapping']);

        $userModel  = new \Application\Models\User($dbConnection, $session);
        $fileModel  = new \Application\Models\File($dbConnection, $userModel,  __DIR__ . '/data');
        $view       = new \Application\Views\Files\EditPopup($userModel, $fileModel, $request, $csrfToken);
        $controller = new \Application\Controllers\File();
        $response   = $controller->editPopup($view);
        break;

    case $requestMatcher->doesMatch($routes['user/uploads/file/edit/update']['requirements']):
        $request->setPathVariables($routes['user/uploads/file/edit/update']['mapping']);

        $userModel  = new \Application\Models\User($dbConnection, $session);
        $fileModel  = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $view       = new \Application\Views\Files\Edit($request);
        $controller = new \Application\Controllers\File();
        $response   = $controller->edit($view, $request, $fileModel, $csrfToken);
        break;

    case $requestMatcher->doesMatch($routes['user/uploads/file/delete']['requirements']):
        $request->setPathVariables($routes['user/uploads/file/delete']['mapping']);

        $fileFactory = new FileFactory();

        $userModel  = new \Application\Models\User($dbConnection, $session);
        $fileModel  = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $view       = new \Application\Views\Files\Delete($userModel, $fileModel, $request, $csrfToken, $fileFactory);
        $controller = new \Application\Controllers\File();
        $response   = $controller->delete($view);
        break;

    case $requestMatcher->doesMatch($routes['download/user']['requirements']):
        $request->setPathVariables($routes['download/user']['mapping']);

        $fileFactory = new FileFactory();

        $userModel     = new \Application\Models\User($dbConnection, $session);
        $fileModel     = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $downloadModel = new \Application\Models\Download($dbConnection, $userModel, $fileModel, $fileFactory, __DIR__ . '/data');
        $view          = new \Application\Views\Files\Download($request, $downloadModel, $userModel);
        $controller    = new \Application\Controllers\File();
        $response      = $controller->download($view);
        break;

    case $requestMatcher->doesMatch($routes['download/id']['requirements']):
        $request->setPathVariables($routes['download/id']['mapping']);

        $fileFactory = new FileFactory();

        $userModel     = new \Application\Models\User($dbConnection, $session);
        $fileModel     = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $downloadModel = new \Application\Models\Download($dbConnection, $userModel, $fileModel, $fileFactory, __DIR__ . '/data');
        $view          = new \Application\Views\Files\Download($request, $downloadModel, $userModel, $session);
        $controller    = new \Application\Controllers\File();
        $response      = $controller->download($view);
        break;

    case $requestMatcher->doesMatch($routes['download/password/verify/password']['requirements']):
        $request->setPathVariables($routes['download/password/verify/password']['mapping']);

        $userModel     = new \Application\Models\User($dbConnection, $session);
        $fileModel     = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $view          = new \Application\Views\Files\PasswordVerify($request, $fileModel, $session);
        $controller    = new \Application\Controllers\File();
        $response      = $controller->verifyPassword($view);
        break;

    case $requestMatcher->doesMatch($routes['download/password/verify/login']['requirements']):
        $request->setPathVariables($routes['download/password/verify/login']['mapping']);

        $userModel     = new \Application\Models\User($dbConnection, $session);
        $fileModel     = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $view          = new \Application\Views\Files\LoginVerify($request, $fileModel, $userModel, $csrfToken);
        $controller    = new \Application\Controllers\File();
        $response      = $controller->verifyLogin($view);
        break;

    case $requestMatcher->doesMatch($routes['download/file']['requirements']):
        $request->setPathVariables($routes['download/file']['mapping']);

        $fileFactory = new FileFactory();

        $userModel     = new \Application\Models\User($dbConnection, $session);
        $fileModel     = new \Application\Models\File($dbConnection, $userModel, __DIR__ . '/data');
        $downloadModel = new \Application\Models\Download($dbConnection, $userModel, $fileModel, $fileFactory, __DIR__ . '/data');
        $view          = new \Application\Views\Files\DownloadFile($request, $downloadModel, $userModel, $session);
        $controller    = new \Application\Controllers\File();
        $response      = $controller->downloadFile($view);
        break;

    default:
        // 404
        break;
}

/**
 * display the output
 */
echo $response->render();