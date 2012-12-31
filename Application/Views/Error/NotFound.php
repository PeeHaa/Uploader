<?php
/**
 * 404 page view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Error
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Error;

use Application\Views\BaseView,
    RichUploader\Http\RequestData,
    Application\Models\User,
    RichUploader\Security\CsrfToken;

/**
 * 404 page view
 *
 * @category   Application
 * @package    Views
 * @subpackage Error
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class NotFound extends BaseView
{
    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * @var \RichUploader\Security\CsrfToken The CSRF token
     */
    private $csrfToken;

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestData   $request   The request
     * @param \Application\Models\User         $userModel The user model
     * @param \RichUploader\Security\CsrfToken $csrfToken The CSRF token
     */
    public function __construct(RequestData $request, User $userModel, CsrfToken $csrfToken)
    {
        $this->request   = $request;
        $this->userModel = $userModel;
        $this->csrfToken - $csrfToken;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        return $this->renderPage('error/not-found.phtml');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['title']          = 'Not found';
        $this->templateVariables['csrfToken']      = $this->csrfToken->getToken();
    }
}