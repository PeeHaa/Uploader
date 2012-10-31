<?php
/**
 * Session class. Instead of directly calling the $_SESSION superglobal we are using this class so that
 * testing will be more easy.
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
 * Session class. Instead of directly calling the $_SESSION superglobal we are using this class so that
 * testing will be more easy.
 *
 * @category   RichUploader
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Session
{
    /**
     * Sets the value
     *
     * @param string $key   The key in which to store the value
     * @param mixed  $value The value to store
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a value from the session superglobal
     *
     * @param mixed $key The key of which to retrieve the value
     *
     * @return mixed The value
     * @throws \OutOfBoundsException When the key is not found
     */
    public function get($key)
    {
        if (!$this->isKeyValid($key)) {
            throw new \OutOfBoundsException('Key (`' . $key . '`) not found in session.');
        }

        return $_SESSION[$key];
    }

    /**
     * Check whether the supplied key is valid (i.e. does exist in the session superglobal)
     *
     * @param string $key The key to check
     *
     * @return boolean Whether the supplied key is valid
     */
    public function isKeyValid($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            return true;
        }

        return false;
    }
}