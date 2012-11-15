<?php
/**
 * The base view. All views should extends this class.
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views;

/**
 * The base view. All views should extends this class.
 *
 * @category   Application
 * @package    Views
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class BaseView
{
    /**
     * @var array The variables to be send to the template
     */
    protected $templateVariables = [];

    /**
     * Sets the template variables and renders the page
     *
     * @param string $contentTemplate The template used to fill the content of the page
     *
     * @return string The rendered HTML page
     */
    public function renderPage($contentTemplate)
    {
        $this->templateVariables['pageContent'] = $this->renderTemplate($contentTemplate);

        ob_start();
        require '../Templates/base/page.phtml';

        $renderedPage = ob_get_contents();
        ob_end_clean();

        return $renderedPage;
    }

    /**
     * Sets the template variables and renders the template
     *
     * @param string $templateFile The path to the template
     *
     * @return string The rendered HTML
     */
    public function renderTemplate($templateFile)
    {
        $this->setTemplateVariables();

        ob_start();
        require '../Templates/' . $templateFile;

        $renderedHtml = ob_get_contents();
        ob_end_clean();

        return $renderedHtml;
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables() {}
}