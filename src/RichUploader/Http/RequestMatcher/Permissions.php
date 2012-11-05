<?php
/**
 * Check whether a request matches with permission requirements
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Http
 * @package    RequestMatcher
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\Http\RequestMatcher;

use RichUploader\Acl\Verifier,
    RichUploader\Http\RequestMatcher\Matchable;

/**
 * Check whether a request matches with permission requirements
 *
 * @category   RichUploader
 * @package    Http
 * @package    RequestMatcher
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Permissions implements Matchable
{
    /**
     * @var \RichUploader\Acl\verifier The access control list
     */
    private $acl;

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\Request $request The request to check for requirements
     */
    public function __construct(Verifier $acl)
    {
        $this->acl = $acl;
    }

    /**
     * Check whether the requirements match
     *
     * @param boolean $requirement The requirement to check against
     *
     * @return boolean Whether the requirement matches
     */
    public function doesMatch($requirement)
    {
        $match = true;

        foreach ($requirement as $role) {
            switch ($req) {
                case 'match':
                    $match = $this->acl->doesRoleMatch($role);
                    break;

                case 'minimum':
                    $match = $this->acl->doesRoleMatchMinimumAccesslevel($role);
                    break;

                case 'maximum':
                    $match = $this->acl->doesRoleMatchMaximumAccesslevel($role);
                    break;
            }

            if ($match === false) {
                return false;
            }
        }

        return true;
    }
}