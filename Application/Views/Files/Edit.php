<?php
/**
 * Edit file view
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
    Application\Models\User,
    Application\Models\File,
    RichUploader\Security\CsrfToken;

/**
 * Edit file view
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Edit extends BaseView
{
    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \Application\Models\UserModel The user model
     */
    private $userModel;

    /**
     * @var \Application\Models\FileModel The file model
     */
    private $fileModel;

    /**
     * @var \RichUploader\Security\CsrfToken The csrf token
     */
    private $csrfToken;

    /**
     * @var array The result of the form submit
     */
    private $result = [];

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestData   $request   The request
     * @param \Application\Models\UserModel    $userModel The user model
     * @param \Application\Models\FileModel    $fileModel The file model
     * @param \RichUploader\Security\CsrfToken $csrfToken The csrf token
     */
    public function __construct(RequestData $request, User $userModel, File $fileModel, CsrfToken $csrfToken)
    {
        $this->request   = $request;
        $this->userModel = $userModel;
        $this->fileModel = $fileModel;
        $this->csrfToken = $csrfToken;
    }

    /**
     * Sets the result of the form submit
     *
     * @param array $result The result of the form submit
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            if (empty($this->result['errors'])) {
                header('Location: /your-files');
                exit();
            }

            return $this->renderPage('file/edit-popup.phtml');
        }

        return $this->renderTemplate('file/edit.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $fileInfo = $this->fileModel->getFileById($this->request->getPathVariable('id'));
        $this->templateVariables['name']           = $this->request->getPostVariable('name');
        $this->templateVariables['description']    = $this->request->getPostVariable('description');
        $this->templateVariables['access']         = $this->request->getPostVariable('access');
        $this->templateVariables['result']         = $this->result;
        $this->templateVariables['csrfToken']      = $this->csrfToken->getToken();
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['fileInfo']       = $fileInfo;
    }
}