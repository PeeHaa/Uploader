<?php
/**
 * Login verify file view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Files;

use Application\Views\BaseView,
    RichUploader\Http\RequestData,
    Application\Models\File,
    Application\Models\User,
    RichUploader\Security\CsrfToken;

/**
 * Login verify file view
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class LoginVerify extends BaseView
{
    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \Application\Models\File The file model
     */
    private $fileModel;

    /**
     * @var \Application\Models\User The session
     */
    private $userModel;

    /**
     * @var \RichUploader\Security\CsrfToken The csrf token instance
     */
    private $csrfToken;

    /**
     * @var boolean The result of the login action
     */
    private $result;

    /**
     * Creates instance Application\Models\Download
     *
     * @param \RichUploader\Http\RequestData   $request   The request
     * @param \Application\Models\File         $fileModel The download model
     * @param \Application\Models\User         $session   The session
     * @param \RichUploader\Security\CsrfToken $csrfToken The csrf token instance
     */
    public function __construct(RequestData $request, File $fileModel, User $userModel, CsrfToken $csrfToken)
    {
        $this->request   = $request;
        $this->fileModel = $fileModel;
        $this->userModel = $userModel;
        $this->csrfToken = $csrfToken;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        $this->result = $this->userModel->login(
            $this->request->getPostVariable('username'),
            $this->request->getPostVariable('password'),
            $this->csrfToken
        );

        if ($this->request->getPathVariable('json', false) === false) {
            if ($this->result === true) {
                // redirect to download page
            } else {
                // load login page
            }
        }

        return $this->renderTemplate('file/download-verify-login.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['result'] = [
            'result' => $this->result ? 'success' : 'failure',
        ];

        if ($this->result === true) {
            $this->templateVariables['result']['url'] = '/download/' . $this->request->getPathVariable('id');
        }
    }
}