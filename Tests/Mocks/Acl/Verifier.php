<?php
/**
 * An Mocked ACL container. This class provides a secure container from which the controller actions will be called
 * after checking hte permissions
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Mocks
 * @subpackage Acl
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploaderTest\Mocks\Acl;

use RichUploader\Acl\Verifiable;

/**
 * An Mocked ACL container. This class provides a secure container from which the controller actions will be called
 * after checking hte permissions
 *
 * @category   RichUploader
 * @package    Mocks
 * @subpackage Acl
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Verifier implements Verifiable
{
    /**
     * @var array The return values if the check requirements methods
     */
    protected $returnValues = [];

    /**
     * Creates instance
     *
     * @param array  $returnValues The return values if the check requirements methods
     */
    public function __construct(array $returnValues)
    {
        $this->returnValues = $returnValues;
    }

    /**
     * Adds the roles of the system. The roles are simply an multidimensional array with the role as key. As value
     * the role contains an array with a numeric accesslevel (higher means a higher accesslevel).
     *
     * @param array $roles The roles of the system
     */
    public function addRoles(array $roles)
    {
    }

    /**
     * Check whether the role exactly matches with the user's role
     *
     * @param string $permission The role needed to access an item
     *
     * @return boolean Whether the current user has access
     */
    public function doesRoleMatch($permission)
    {
        return $this->returnValues['match'];
    }

    /**
     * Check whether the user role meets the minimum accesslevel
     *
     * @param string $permission The role needed to access an item
     *
     * @return boolean Whether the current user has access
     */
    public function doesRoleMatchMinimumAccesslevel($permission)
    {
        return $this->returnValues['minimum'];
    }

    /**
     * Check whether the user role meets the maximum accesslevel
     *
     * @param string $permission The role needed to access an item
     *
     * @return boolean Whether the current user has access
     */
    public function doesRoleMatchMaximumAccesslevel($permission)
    {
        return $this->returnValues['maximum'];
    }
}