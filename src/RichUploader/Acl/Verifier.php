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
     * the role contains an array with either a numeric accesslevel (higher means a higher accesslevel) or
     * an 'exclusive' array to give the role only access to items which can be accessed from roles within the
     * 'exclusive' array.
     *
     * @param array $roles The roles of the system
     *
     * @throws \DomainException When there is no accesslevel
     */
    public function addRoles(array $roles)
    {
        $parsedRoles = [];
        foreach ($roles as $role => $options) {
            if (!array_key_exists('accesslevel')) {
                throw new \DomainException(
                    'No Accesslevel defined for the role (`' . $role . '`).'
                );
            }

            $this->roles[$role] = $options;
        }
    }

    /**
     * Check whether the current user has access to an item by checking the provided permission
     *
     * @param string $permission The role needed to access an item
     *
     * @return boolean Whether the current user has access
     */
    public function hasAccess($permission)
    {
        $role = $this->guestRole;
        if ($this->session->isKeyValid('user')) {
            $user = $this->session->get('user');
            if (array_key_exists('role', $user)) {
                $role = $user['role'];
            }
        }

        if (!array_key_exists($role, $this->roles)) {
            return false;
        }

        $userRole = $this->roles[$role];

        if (array_key_exists('exclusive', $userRole) && in_array($permission, $userRole['exclusive']) {
            return true;
        }

        if (array_key_exists($permission, $this->roles) && $userRole['accesslevel'] >= $this->roles[$permission]) {
            return true;
        }

        return false;
    }
}