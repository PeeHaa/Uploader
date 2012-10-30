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
    Application\Views\User\LoginPopup;

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
     * @param \Application\Views\User\LoginPopup $view    The login popup view
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
     * @param array                         $request The request parameters
     *
     * @return string The rendered view
     */
    public function login(Login $view, array $request)
    {
        if (array_key_exists('username', $request)) {
            $view->setUsername($request['username']);
        }

        if (array_key_exists('password', $request)) {
            $view->setPassword($request['password']);
        }

        return $view;
    }
}