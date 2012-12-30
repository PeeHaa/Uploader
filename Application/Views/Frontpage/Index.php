<?php
/**
 * Frontpage view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Frontpage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Frontpage;

use Application\Views\BaseView,
    Application\Models\User,
    RichUploader\Security\CsrfToken,
    RichUploader\Http\RequestData;

/**
 * Frontpage view
 *
 * @category   Application
 * @package    Views
 * @subpackage Frontpage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Index extends BaseView
{
    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * @var string The supplied CSRF token
     */
    private $token;

    /**
     * $var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * Creates instance
     *
     * @param \Application\Models\User           $userModel The user model
     * @param \RichUploader\Security\CsrfToken   $csrfToken The CSRF token
     * @param \RichUploader\Http\RequestData     $request   The request
     */
    public function __construct(\Application\Models\User $userModel, CsrfToken $csrfToken, RequestData $request)
    {
        $this->userModel = $userModel;
        $this->csrfToken = $csrfToken;
        $this->request   = $request;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            if ($this->userModel->isLoggedIn()) {
                return $this->renderPage('upload/uploader.phtml');
            } else {
                return $this->renderPage('base/intro.phtml');
            }
        }

        if ($this->userModel->isLoggedIn()) {
            return $this->renderTemplate('upload/uploader.pjson');
        }
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['title']          = 'Upload';
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['csrfToken']      = $this->csrfToken->getToken();
    }
}