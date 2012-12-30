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
    Application\Views\Pages\Tos;

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
     * @param \Application\Views\Pages\Tos $view The about view
     *
     * @return string The rendered view
     */
    public function tos(Tos $view)
    {
        return $view;
    }
}