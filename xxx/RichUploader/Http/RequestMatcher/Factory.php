<?php
/**
 * Builds the request matchers for the different types in the request
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

use RichUploader\Http\Request,
    RichUploader\Acl\Verifier,
    RichUploader\Http\RequestMatcher\Matchable;

/**
 * Builds the request matchers for the different types in the request
 *
 * @category   RichUploader
 * @package    Http
 * @package    RequestMatcher
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Factory
{
    /**
     * @var \RichUploader\Http\Request The request to check whether it matches with the requirements
     */
    private $request;

    /**
     * @var \RichUploader\Acl\Verifier The access control list
     */
    private $acl;

    /**
     * Creates instance
     *
     * @param \RichUploader\Http\Request The request to check whether it matches with the requirements
     * @param \RichUploader\Acl\Verifier The access control list
     */
    public function __construct(Request $request, Verifier $acl)
    {
        $this->request = $request;
        $this->acl     = $acl;
    }

    /**
     * Build instances of RequestMatchers
     *
     * @param  string $type The type of RequestMatcher to build
     *
     * @return \RichUploader\Http\RequestMatcher\Matchable The instance of the matchable
     * @throws \UnexpectedValueException When the matchable class doesn't exists
     * @throws \UnexpectedValueException When the possible matchable class doesn't implement the Matchable interface
     */
    public function build($type)
    {
        $class = '\\RichUploader\\Http\\RequestMatcher\\' . ucfirst(strtolower($type));

        if (!class_exists($class)) {
            throw new \UnexpectedValueException('Unknown RequestMatcher (`' . $class . '`).');
        }

        if ($type == 'permissions') {
            $matcher = new $class($this->acl);
        } else {
            $matcher = new $class($this->request);
        }

        if (!($matcher instanceof Matchable)) {
            throw new \UnexpectedValueException('Class (`' . $class . '`) does not implement the RequestMatcher interface.');
        }

        return $matcher;
    }
}