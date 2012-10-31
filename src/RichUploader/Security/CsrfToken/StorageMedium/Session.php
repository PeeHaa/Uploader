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

use RichUploader\Security\CsrfToken\StorageMedium,
    RichUploader\Storage\Session as SessionStorage;

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
     * \RichUpload\Storage\Session Instance of the session class
     */
    private $session;

    /**
     * Creates instance
     *
     * @param string $key The key under which to store the token
     * @param \RichUpload\Storage\Session Instance of the session class
     */
    public function __construct($key, SessionStorage $session)
    {
        $this->key     = $key;
        $this->session = $session;
    }

    /**
     * Sets the CSRF token
     *
     * @param string $token The token to store
     */
    public function set($token)
    {
        $this->session->set($this->key, $token);
    }

    /**
     * Gets the CSRF token
     *
     * @return string|null The CSRF token or null when there isn't a token stored (yet)
     */
    public function get()
    {
        if ($this->session->isKeyvalid($this->key)) {
            return $this->session->get($this->key);
        }

        return null;
    }
}