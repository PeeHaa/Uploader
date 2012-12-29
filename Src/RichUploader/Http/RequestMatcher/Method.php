<?php
/**
 * Check whether a request matches with method requirements
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

use RichUploader\Http\RequestData,
    RichUploader\Http\RequestMatcher\Matchable;

/**
 * Check whether a request matches with method requirements
 *
 * @category   RichUploader
 * @package    Http
 * @package    RequestMatcher
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Method implements Matchable
{
    /**
     * @var \RichUploader\Http\Request The request
     */
    private $request;

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestData $request The request to check for requirements
     */
    public function __construct(RequestData $request)
    {
        $this->request = $request;
    }

    /**
     * Check whether the requirements match
     *
     * @param string $requirement The requirement to check against
     *
     * @return boolean Whether the requirement matches
     */
    public function doesMatch($requirement)
    {
        if (strtolower($this->request->getMethod()) == strtolower($requirement)) {
            return true;
        }

        return false;
    }
}