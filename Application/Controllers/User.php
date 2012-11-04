<?php
/**
 * User controller
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Controllers;

use Application\Views\User\Login,
    Application\Views\User\LoginPopup,
    Application\Views\User\Logout,
    RichUploader\Http\Request;

/**
 * User controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class User
{
    /**
     * Sets up the login popup view
     *
     * @param \Application\Views\User\LoginPopup $view         The login popup view
     *
     * @return string The rendered view
     */
    public function loginPopup(LoginPopup $view)
    {
        return $view;
    }

    /**
     * Sets up the login view
     *
     * @param \Application\Views\User\Login $view    The login view
     * @param \RichUploader\Http\Request    $request The request parameters
     *
     * @return string The rendered view
     */
    public function login(Login $view, Request $request)
    {
        if ($request->getPostVariable('username') !== null) {
            $view->setUsername($request->getPostVariable('username'));
        }

        if ($request->getPostVariable('password') !== null) {
            $view->setPassword($request->getPostVariable('password'));
        }

        if ($request->getPostVariable('csrf-token') !== null) {
            $view->setToken($request->getPostVariable('csrf-token'));
        }

        return $view;
    }

    /**
     * Sets up the login view
     *
     * @param \Application\Views\User\Logout $view    The logout view
     * @param \RichUploader\Http\Request     $request The request parameters
     *
     * @return string The rendered view
     */
    public function logout(Logout $view, Request $request)
    {
        if ($request->getPathVariable('csrf-token') !== null) {
            $view->setToken($request->getPathVariable('csrf-token'));
        }

        return $view;
    }
}