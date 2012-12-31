<?php
/**
 * Error controller
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

use Application\Views\Error\NotFound;

/**
 * Error controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Error
{
    /**
     * Sets up the login view
     *
     * @param \Application\Views\Error\NotFound $view The 404 view
     *
     * @return string The rendered view
     */
    public function notFound(NotFound $view)
    {
        return $view;
    }
}