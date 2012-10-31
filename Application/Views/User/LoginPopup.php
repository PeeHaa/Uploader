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
    RichUploader\Security\CsrfToken;

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
     * Creates instance
     *
     * @param \RichUploader\Security\CsrfToken   $csrfToken    The CSRF token
     */
    public function __construct(CsrfToken $csrfToken)
    {
        $this->csrfToken = $csrfToken;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        return $this->renderTemplate('user/login-popup.phtml');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['csrfToken'] = $this->csrfToken->getToken();
    }
}