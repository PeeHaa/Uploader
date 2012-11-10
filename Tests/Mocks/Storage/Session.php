<?php
/**
 * Session class. Instead of directly calling the $_SESSION superglobal we are using this class so that
 * testing will be more easy.
 *
 * PHP version 5.4
 *
 * @category   RichUploaderTest
 * @package    Mocks
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploaderTest\Mocks\Storage;

use RichUploader\Storage\SessionInterface;

/**
 * Session class. Instead of directly calling the $_SESSION superglobal we are using this class so that
 * testing will be more easy.
 *
 * @category   RichUploaderTest
 * @package    Mocks
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Session implements SessionInterface
{
    /**
     * @var array The data used in this mock
     */
    private $data = [];

    /**
     * Creates instance.
     *
     * @param array $data The data with which to initialize the mock
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Sets the value
     *
     * @param string $key   The key in which to store the value
     * @param mixed  $value The value to store
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Gets a value from the data
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

       return $this->data[$key];
    }

    /**
     * Check whether the supplied key is valid (i.e. does exist in the data)
     *
     * @param string $key The key to check
     *
     * @return boolean Whether the supplied key is valid
     */
    public function isKeyValid($key)
    {
        if (array_key_exists($key, $this->data)) {
            return true;
        }

        return false;
    }

    /**
     * Regenerates a new session id and initializes the data
     */
    public function regenerate()
    {
        //session_regenerate_id(true);
        $this->data = [];
    }
}