<?php
/**
 * Index (a.k.a. frontpage) controller
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

use Application\Views\Frontpage\Index as FrontpageView;

/**
 * Index (a.k.a. frontpage) controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Index
{
    /**
     * Sets up the login view
     *
     * @param \Application\Views\Frontpage\Index $view The frontpage view
     *
     * @return string The rendered view
     */
    public function frontpage(FrontpageView $view)
    {
        return $view;
    }
}