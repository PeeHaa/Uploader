<?php
/**
 * Delete file view
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
    RichUploader\Security\CsrfToken,
    RichUploader\FileSystem\FileFactory;

/**
 * Delete file view
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Delete extends BaseView
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
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \RichUploader\Security\CsrfToken The csrf token
     */
    private $csrfToken;

    /**
     * @var \RichUploader\FileSystem\FileFactory The file factory
     */
    private $fileFactory;

    /**
     * Creates instance
     *
     * @param \Application\Models\UserModel        $userModel   The user model
     * @param \Application\Models\FileModel        $fileModel   The file model
     * @param \RichUploader\Http\RequestData       $request     The request
     * @param \RichUploader\Security\CsrfToken     $csrfToken   The csrf token
     * @param \RichUploader\FileSystem\FileFactory $fileFactory The file factory
     */
    public function __construct(User $userModel, File $fileModel, RequestData $request, CsrfToken $csrfToken, FileFactory $fileFactory)
    {
        $this->userModel   = $userModel;
        $this->fileModel   = $fileModel;
        $this->request     = $request;
        $this->csrfToken   = $csrfToken;
        $this->fileFactory = $fileFactory;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        return $this->renderTemplate('file/delete.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['result'] = false;
        if ($this->csrfToken->validate($this->request->getPathVariable('csrf-token')) && $this->fileModel->deleteByid($this->request->getPathVariable('id'), $this->fileFactory)) {
            $this->templateVariables['result'] = true;
        }
    }
}