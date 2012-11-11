<?php
/**
 * Part of the model layer that takes of files on the system
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Models;

use Application\Models\User;

/**
 * Part of the model layer that takes of files on the system
 *
 * @todo       Add extra layer for storage abstraction
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class File
{
    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * @var \Application\Models\User Instance of the user model
     */
    private $userModel;

    /**
     * Creates instance
     *
     * @param \PDO                                 $dbConnection  The database connection
     * @param \Application\Models\User             $session       The session
     */
    public function __construct(\PDO $dbConnection, User $userModel)
    {
        $this->dbConnection  = $dbConnection;
        $this->userModel     = $userModel;
    }
}