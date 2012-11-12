<?php
/**
 * Login popup view
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
    Application\Models\File;

/**
 * Login popup view
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
     * Creates instance
     *
     * @param \Application\Models\UserModel $userModel The user model
     * @param \Application\Models\FileModel $fileModel The file model
     */
    public function __construct(User $userModel, File $fileModel)
    {
        $this->userModel = $userModel;
        $this->fileModel = $fileModel;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        return $this->renderTemplate('file/list.phtml');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['files'] = $this->fileModel->getFilesOfCurrentUser();
    }
}