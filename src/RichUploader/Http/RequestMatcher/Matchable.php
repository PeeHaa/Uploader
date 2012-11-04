<?php
/**
 * Interface for classes that try to match requirements for a request
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

use RichUploader\Http\Request;

/**
 * Interface for classes that try to match requirements for a request
 *
 * @category   RichUploader
 * @package    Http
 * @package    RequestMatcher
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Matchable
{
    /**
     * Creates instance
     *
     * @param \RichUploader\Http\Request $request The request to check for requirements
     */
    public function __construct(Request $request);

    /**
     * Check whether the requirements match
     *
     * @param mixed $requirement The requirement to check against
     *
     * @return boolean Whether the requirement matches
     */
    public function doesMatch($requirement);
}