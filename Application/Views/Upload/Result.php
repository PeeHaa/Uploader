<?php
/**
 * Upload result view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Upload;

use Application\Views\BaseView,
    RichUploader\Http\RequestData,
    Application\Models\User;

/**
 * Upload result view
 *
 * @category   Application
 * @package    Views
 * @subpackage Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Result extends BaseView
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
     * @var array The result of the upload
     */
    private $result = [];

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestData $request   The request
     * @param \Application\Models\User       $userModel The user model
     */
    public function __construct(RequestData $request, User $userModel)
    {
        $this->request   = $request;
        $this->userModel = $userModel;
    }

    /**
     * Sets the result of the upload
     *
     * @param array $result The result of the array
     */
    public function setResult(array $result)
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
        if ($this->request->getPathVariable('filename', false) === false) {
            if (isset($this->result['success']) && $this->result['success'] === true) {
                header('Location: /your-files');
                exit();
            }
            return $this->renderPage('upload/result.phtml');
        }

        return $this->renderTemplate('upload/result.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['result'] = json_encode($this->result);
        if (!isset($this->result['success']) || $this->result['success'] !== true) {
            $this->templateVariables['error'] = json_encode($this->result['error']);
        }
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
    }
}