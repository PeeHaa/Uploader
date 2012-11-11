<?php
/**
 * Contains all the information of a HTTP request
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

use RichUploader\Http\RequestData;

/**
 * Contains all the information of a HTTP request
 *
 * @category   RichUploader
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Request implements RequestData
{
    /**
     * @var array The server variables
     */
    private $serverVariables = [];

    /**
     * @var array The get variables
     */
    private $getVariables = [];

    /**
     * @var array The post variables
     */
    private $postVariables = [];

    /**
     * @var array The elements in the path
     */
    private $path = [];

    /**
     * @var array Maps elements in the path to variables
     */
    private $pathVariables = [];

    /**
     * Creates instance
     *
     * @param array $serverVariables The variables from the $_SERVER superglobal
     * @param array $getVariables    The variables from the $_GET superglobal
     * @param array $postVariables   The variables from the $_POST superglobal
     */
    public function __construct(array $serverVariables, array $getVariables, array $postVariables)
    {
        $this->serverVariables  = $serverVariables;
        $this->getVariables     = $getVariables;
        $this->postVariables    = $postVariables;

        $this->setPath();
    }

    /**
     * Sets the path elements of the URI
     */
    private function setPath()
    {
        $barePath = $this->getBarePath();

        $this->path = explode('/', $barePath);
    }

    /**
     * Gets the bare path from the URI. All outer slashes will be stripped.
     *
     * @return string The bare path
     */
    private function getBarePath()
    {
        $currentPath = current(explode('?', $this->serverVariables['REQUEST_URI'], 2));

        return trim($currentPath, '/');
    }

    /**
     * Gets the path of the URI
     *
     * @return string The path
     */
    public function getPath()
    {
        return '/' . implode('/', $this->path);
    }

    /**
     * Sets up the mapping of path parts to request variables
     *
     * @param array $mapping The mapping from path parts to request variables
     *
     * @throws \UnexpectedValueException When trying to map an path part which doesn't exist
     */
    public function setPathVariables(array $mapping)
    {
        foreach ($mapping as $key => $pathPartIndex) {
            if (!array_key_exists($pathPartIndex, $this->path)) {
                throw new \UnexpectedValueException(
                    'Trying to map a path variable (with index `' . $pathPartIndex . '`) which doesn\'t exist.'
                );
            }

            $this->pathVariables[$key] = $this->path[$pathPartIndex];
        }
    }

    /**
     * Gets the get variables
     *
     * @return array The get variables
     */
    public function getGetVariables()
    {
        return $this->getVariables;
    }

    /**
     * Gets a get variable
     *
     * @return mixed The get variable value (or null if it doesn't exists)
     */
    public function getGetVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->getVariables) ? $this->getVariables[$key] : $defaultValue);
    }

    /**
     * Gets the post variables
     *
     * @return array The post variables
     */
    public function getPostVariables()
    {
        return $this->postVariables;
    }

    /**
     * Gets a post variable
     *
     * @return mixed The post variable value (or null if it doesn't exists)
     */
    public function getPostVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->postVariables) ? $this->postVariables[$key] : $defaultValue);
    }

    /**
     * Gets the path variables
     *
     * @return array The path variables
     */
    public function getPathVariables()
    {
        return $this->pathVariables;
    }

    /**
     * Gets a path variable
     *
     * @return mixed The path variable value (or null if it doesn't exists)
     */
    public function getPathVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->pathVariables) ? $this->pathVariables[$key] : $defaultValue);
    }

    /**
     * Gets the HTTP method
     *
     * @return string The HTTP method
     */
    public function getMethod()
    {
        return $this->serverVariables['REQUEST_METHOD'];
    }

    /**
     * Gets the host
     *
     * @return string The host
     */
    public function getHost()
    {
        return $this->serverVariables['HTTP_HOST'];
    }

    /**
     * Check whether the connection is over SSL
     *
     * @return boolean Whether the connection is over SSL
     */
    public function isSsl()
    {
        return !(empty($this->serverVariables['HTTPS']) || $this->serverVariables['HTTPS'] == 'off');
    }
}