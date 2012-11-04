<?php
/**
 * Logout view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage User
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\User;

use Application\Views\BaseView,
    Application\Models\User,
    RichUploader\Security\CsrfToken;

/**
 * Logout view
 *
 * @category   Application
 * @package    Views
 * @subpackage User
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Logout extends BaseView
{
    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * @var \RichUploader\Security\CsrfToken The CSRF token
     */
    private $csrfToken;

    /**
     * @var string The supplied CSRF token
     */
    private $token;

    /**
     * Creates instance
     *
     * @param \Application\Models\User           $userModel The user model
     * @param \RichUploader\Security\CsrfToken   $csrfToken The CSRF token
     */
    public function __construct(User $userModel, CsrfToken $csrfToken)
    {
        $this->userModel = $userModel;
        $this->csrfToken = $csrfToken;
    }

    /**
     * Sets the supplied CSRF token
     *
     * @param string $token The supplied CSRF token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Loads the frontpage
     */
    public function render()
    {
        echo 'logging out the user';
        if ($this->csrfToken->validate($this->token)) {
            echo 'token is valid';
            $this->userModel->logout();
        }
        echo 'test'; die;

        header('Location: http://uploader.localhost');
        exit();
    }
}