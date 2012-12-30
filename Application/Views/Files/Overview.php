<?php
/**
 * Overview of files view
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
    Application\Models\User,
    Application\Models\File,
    RichUploader\Http\RequestData,
    RichUploader\Security\CsrfToken;

/**
 * Overview of files view
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Overview extends BaseView
{
    /**
     * @var \Application\Models\UserModel The user model
     */
    private $userModel;

    /**
     * @var \Application\Models\FileModel The file model
     */
    private $fileModel;

    /**
     * $var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \RichUploader\Security\CsrfToken The csrf token
     */
    private $csrfToken;

    /**
     * Creates instance
     *
     * @param \Application\Models\UserModel    $userModel The user model
     * @param \Application\Models\FileModel    $fileModel The file model
     * @param \RichUploader\Http\RequestData   $request   The request
     * @param \RichUploader\Security\CsrfToken $csrfToken The csrf token
     */
    public function __construct(User $userModel, File $fileModel, RequestData $request, CsrfToken $csrfToken)
    {
        $this->userModel = $userModel;
        $this->fileModel = $fileModel;
        $this->request   = $request;
        $this->csrfToken = $csrfToken;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            return $this->renderPage('file/list.phtml');
        }

        return $this->renderTemplate('file/list.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['title']          = 'Your files';
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['files']          = $this->fileModel->getFilesOfCurrentUser();
        $this->templateVariables['csrfToken']      = $this->csrfToken->getToken();
        $this->templateVariables['menu']           = 'overview';
    }
}