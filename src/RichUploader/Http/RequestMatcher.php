<?php
/**
 * Matches a request against a set of requirements
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\Http;

use RichUploader\Http\RequestMatcher\Factory;

/**
 * Matches a request against a set of requirements
 *
 * @category   RichUploader
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class RequestMatcher
{
    /**
     * @var \RichUploader\Http\RequestMatcher\Factory Factory which build matchers for the different types
     *                                                to match against
     */
    private $matcherFactory;

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\RequestMatcher\Factory Factory which build matchers for the different types
     *                                                  to match against
     */
    public function __construct(Factory $matcherFactory)
    {
        $this->matcherFactory = $matcherFactory;
    }

    /**
     * Check whether the current request matches with the given requirements. The requirements should be supplied as
     * an array where the key is the type of requirement (i.e. path, method, ssl etc) and the value is the requirement
     * to check against
     *
     * @param array A list of requirements to match
     *
     * @return boolean Whether the request matches
     */
    public function doesMatch(array $requirements)
    {
        foreach ($requirements as $type => $requirement) {
            $matcher = $this->matcherFactory->build($type);

            if (!$matcher->doesMatch($requirement)) {
                return false;
            }
        }

        return true;
    }
}