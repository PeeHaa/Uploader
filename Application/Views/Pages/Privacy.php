<?php
/**
 * Privacy page view
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
    RichUploader\Http\RequestData;

/**
 * Privacy page view
 *
 * @category   Application
 * @package    Views
 * @subpackage Pages
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Privacy extends BaseView
{
    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestData $request The request
     */
    public function __construct(RequestData $request)
    {
        $this->request = $request;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            return $this->renderPage('page/privacy.phtml');
        }

        return $this->renderTemplate('page/privacy.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['title'] = 'Privacy';
    }
}