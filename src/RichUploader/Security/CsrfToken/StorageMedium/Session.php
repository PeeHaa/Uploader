<?php
/**
 * Interface for classes that store CSRF tokens
 *
 * PHP version 5.4
 *
 * @category      RichUploader
 * @package       Security
 * @subpackage    CsrfToken
 * $subsubpackage StorageMedium
 * @author        Pieter Hordijk <info@pieterhordijk.com>
 * @copyright     Copyright (c) 2012 Pieter Hordijk
 * @license       http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version       1.0.0
 */
namespace RichUploader\Security\CsrfToken\StorageMedium;

use RichUploader\Security\CsrfToken\StorageMedium;

/**
 * Interface for classes that store CSRF tokens
 *
 * @category      RichUploader
 * @package       Security
 * @subpackage    CsrfToken
 * $subsubpackage StorageMedium
 * @author        Pieter Hordijk <info@pieterhordijk.com>
 */
class Session implements StorageMedium
{
    /**
     * @var string The key under which to store the token
     */
    private $key;

    /**
     * Creates instance
     *
     * @param string $key The key under which to store the token
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Sets the CSRF token
     *
     * @param string $token The token to store
     */
    public function set($token)
    {
        $_SESSION[$this->key] = $token;
    }

    /**
     * Gets the CSRF token
     *
     * @return string The CSRF token
     */
    public function get()
    {
        if (array_key_exists($this->key, $_SESSION)) {
            return $_SESSION[$this->key];
        }

        return null;
    }
}