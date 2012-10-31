<?php
/**
 * Interface for classes that store CSRF tokens
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Security
 * @subpackage CsrfToken
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\Security\CsrfToken;

/**
 * Interface for classes that store CSRF tokens
 *
 * @category   RichUploader
 * @package    Security
 * @subpackage CsrfToken
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface StorageMedium
{
    /**
     * Sets the CSRF token
     *
     * @param string $token The token to store
     */
    public function set($token);

    /**
     * Gets the CSRF token
     *
     * @return string The CSRF token
     */
    public function get();
}