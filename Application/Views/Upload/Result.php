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

use Application\Views\BaseView;

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
     * @var array The result of the upload
     */
    private $result = [];

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
        return $this->renderTemplate('upload/result.phtml');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['result'] = json_encode($this->result);
    }
}