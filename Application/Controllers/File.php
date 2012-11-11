<?php
/**
 * User controller
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

use Application\Views\Files\Overview;

/**
 * User controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class File
{
    /**
     * Sets up the files list view
     *
     * @param \Application\Views\Files\Overview $view         The files list view
     *
     * @return string The rendered view
     */
    public function overview(Overview $view)
    {
        return $view;
    }
}