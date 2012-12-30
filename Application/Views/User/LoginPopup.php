<?php
/**
 * Login popup view
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
    RichUploader\Security\CsrfToken,
    RichUploader\Http\RequestData,
    Application\Models\User;

/**
 * Login popup view
 *
 * @category   Application
 * @package    Views
 * @subpackage User
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class LoginPopup extends BaseView
{
    /**
     * @var \RichUploader\Security\CsrfToken The CSRF token
     */
    private $csrfToken;

    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * Creates instance
     *
     * @param \RichUploader\Security\CsrfToken $csrfToken The CSRF token
     * @param \RichUploader\Http\RequestData   $request   The request
     * @param \Application\Models\User         $userModel The user model
     */
    public function __construct(CsrfToken $csrfToken, RequestData $request, User $userModel)
    {
        $this->csrfToken = $csrfToken;
        $this->request   = $request;
        $this->userModel = $userModel;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            return $this->renderPage('user/login-popup.phtml');
        }

        return $this->renderTemplate('user/login-popup.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['title']          = 'Login';
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['csrfToken']      = $this->csrfToken->getToken();
    }
}