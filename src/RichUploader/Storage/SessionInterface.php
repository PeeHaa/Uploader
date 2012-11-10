<?php
/**
 * Session interface. All classes which represent a session should implement this. This is useful for creating a mock
 * session class.
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\Storage;

/**
 * Session interface. All classes which represent a session should implement this. This is useful for creating a mock
 * session class.
 *
 * @category   RichUploader
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface SessionInterface
{
    /**
     * Sets the value
     *
     * @param string $key   The key in which to store the value
     * @param mixed  $value The value to store
     */
    public function set($key, $value);

    /**
     * Gets a value from the session superglobal
     *
     * @param mixed $key The key of which to retrieve the value
     *
     * @return mixed The value
     * @throws \OutOfBoundsException When the key is not found
     */
    public function get($key);

    /**
     * Check whether the supplied key is valid (i.e. does exist in the session superglobal)
     *
     * @param string $key The key to check
     *
     * @return boolean Whether the supplied key is valid
     */
    public function isKeyValid($key);

    /**
     * Regenerates a new session id and initializes the session superglobal
     */
    public function regenerate();
}