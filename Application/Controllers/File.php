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

use Application\Views\Files\Overview,
    Application\Views\Files\Edit,
    Application\Views\Files\Delete;

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

    /**
     * Sets up the file edit view
     *
     * @param \Application\Views\Files\Edit $view         The file edit view
     *
     * @return string The rendered view
     */
    public function edit(Edit $view)
    {
        return $view;
    }

    /**
     * Deletes the file of the user
     *
     * @param \Application\Views\Files\Delete $view The delete file view
     *
     * @return string The rendered view
     */
    public function delete(Delete $view)
    {
        return $view;
    }
}