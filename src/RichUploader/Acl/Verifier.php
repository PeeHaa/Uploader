<?php
/**
 * An ACL container. This class provides a secure container from which the controller actions will be called
 * after checking hte permissions
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Acl
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\Acl;

use RichUploader\Storage\Session;

/**
 * An ACL container. This class provides a secure container from which the controller actions will be called
 * after checking hte permissions
 *
 * @category   RichUploader
 * @package    Acl
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Verifier
{
    /**
     * @var \RichUploader\Storage\Session The user session
     */
    private $session;

    /**
     * The name of the guest role (i.e. when somebody is not logged in)
     */
    private $guestRole;

    /**
     * @var array The roles of the system
     */
    private $roles = [];

    /**
     * @var string The name of the user roel of the current user (cache)
     */
    private $userRole;

    /**
     * Creates instance
     *
     * @param string                         $guestRole The name of the guestrole
     * @param \RichUploader\Storage\Session  $session   The user session
     */
    public function __construct(Session $session, $guestRole = 'guest')
    {
        $this->session   = $session;
        $this->guestRole = $guestRole;
    }

    /**
     * Adds the roles of the system. The roles are simply an multidimensional array with the role as key. As value
     * the role contains an array with a numeric accesslevel (higher means a higher accesslevel).
     *
     * @param array $roles The roles of the system
     *
     * @throws \DomainException When there is no accesslevel
     */
    public function addRoles(array $roles)
    {
        $parsedRoles = [];
        foreach ($roles as $role => $options) {
            if (!array_key_exists('accesslevel', $options)) {
                throw new \DomainException(
                    'No Accesslevel defined for the role (`' . $role . '`).'
                );
            }

            $this->roles[$role] = $options;
        }
    }

    /**
     * Gets the role of the current user
     *
     * @return string The name of role of the current user
     * @throws \DomainException When the user's role is not defined
     */
    private function getUserRole()
    {
        if ($this->userRole !== null) {
            return $this->userRole;
        }

        $role = $this->guestRole;
        if ($this->session->isKeyValid('user')) {
            $user = $this->session->get('user');

            if (array_key_exists('role', $user)) {
                $role = $user['role'];
            }
        }

        if (!array_key_exists($role, $this->roles)) {
            throw new \DomainException('The current user\'s role (`' . $role . '`) is not defined.');
        }

        $this->userRole = $role;

        return $role;
    }

    /**
     * Gets the accesslevel of a role
     *
     * @param string The name of the role
     *
     * @return int The accesslevel of the role
     * @throws \DomainException When the role is not defined
     */
    private function getAccesslevelOfRole($role)
    {
        if (!array_key_exists($role, $this->roles)) {
            throw new \DomainException('The current user\'s role (`' . $role . '`) is not defined.');
        }

        return $this->roles[$role]['accesslevel'];
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
        $userRole = $this->getUserRole();

        if ($permission == $userRole) {
            return true;
        }

        return false;
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
        $userRole = $this->getUserRole();

        if ($this->getAccesslevelOfRole($userRole) >= $this->getAccesslevelOfRole($permission)) {
            return true;
        }

        return false;
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
        $userRole = $this->getUserRole();

        if ($this->getAccesslevelOfRole($userRole) <= $this->getAccesslevelOfRole($permission)) {
            return true;
        }

        return false;
    }
}