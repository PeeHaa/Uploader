<?php
/**
 * Login view
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
    RichUploader\Security\CsrfToken,
    RichUploader\Http\RequestData;

/**
 * Login view
 *
 * @category   Application
 * @package    Views
 * @subpackage User
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Login extends BaseView
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
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var string The supplied username
     */
    private $username;

    /**
     * @var string The supplied CSRF token
     */
    private $token;

    /**
     * @var string The supplied password
     */
    private $password;

    /**
     * Creates instance
     *
     * @param \Application\Models\User           $userModel The user model
     * @param \RichUploader\Security\CsrfToken   $csrfToken The CSRF token
     */
    public function __construct(User $userModel, CsrfToken $csrfToken, RequestData $request)
    {
        $this->userModel = $userModel;
        $this->csrfToken = $csrfToken;
        $this->request   = $request;
    }

    /**
     * Sets the supplied username
     *
     * @param string $username The supplied username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Sets the supplied password
     *
     * @param string $password The supplied password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        $this->templateVariables['result']         = ($this->csrfToken->validate($this->token)
            && $this->userModel->login($this->username, $this->password, $this->csrfToken));

        if ($this->request->getPathVariable('json', false) === false) {
            if ($this->templateVariables['result'] === true) {
                header('Location: /');
                exit();
            }

            return $this->renderPage('user/login-popup.phtml');
        }

        return $this->renderTemplate('user/login.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['title']          = 'Login';
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['csrfToken']      = $this->csrfToken->getToken();
        $this->templateVariables['username']       = $this->username;
    }
}