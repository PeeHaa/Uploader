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
    RichUploader\Http\RequestData;

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
     * @var array The result of the form submit
     */
    private $result = [];

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestData   $request   The request
     */
    public function __construct(RequestData $request)
    {
        $this->request   = $request;
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
            return $this->renderPage('file/edit.phtml');
        }

        return $this->renderTemplate('file/edit.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['result'] = $this->result;
    }
}