<?php
/**
 * About page view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Pages
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Pages;

use Application\Views\BaseView,
    RichUploader\Http\RequestData,
    Application\Models\User;

/**
 * About page view
 *
 * @category   Application
 * @package    Views
 * @subpackage Pages
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class About extends BaseView
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
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            return $this->renderPage('page/about.phtml');
        }

        return $this->renderTemplate('page/about.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['title']          = 'About';
    }
}