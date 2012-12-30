<?php
/**
 * Page controller
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Controllers;

use Application\Views\Pages\About,
    Application\Views\Pages\Tos,
    Application\Views\Pages\Privacy;

/**
 * Page controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Page
{
    /**
     * Renders the about page
     *
     * @param \Application\Views\Pages\About $view The about view
     *
     * @return string The rendered view
     */
    public function about(About $view)
    {
        return $view;
    }

    /**
     * Renders the terms of service page
     *
     * @param \Application\Views\Pages\Tos $view The terms of service view
     *
     * @return string The rendered view
     */
    public function tos(Tos $view)
    {
        return $view;
    }

    /**
     * Renders the privacy page
     *
     * @param \Application\Views\Pages\Privacy $view The privacy view
     *
     * @return string The rendered view
     */
    public function privacy(Privacy $view)
    {
        return $view;
    }
}