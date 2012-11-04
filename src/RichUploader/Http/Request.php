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

/**
 * Contains all the information of a HTTP request
 *
 * @category   RichUploader
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Request
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
     * @var array The request variables
     */
    private $requestVariables = [];

    /**
     * @var array The elements in the path
     */
    private $path = [];

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
        $this->requestVariables = $this->setRequestVariables();
        $this->path             = $this->setPath();
    }

    /**
     * Sets the request variables without relying on the $_REQUEST superglobal. It checks PHP's `request_order` ini
     * setting to find out the correct order in which to add the variables from: $_POST and $_GET
     */
    private function setRequestVariables()
    {
        $requestOrder = ini_get('request_order');
        while ($requestOrder) {
            switch (strtolower(substr($requestOrder, 0, 1))) {
                case 'g':
                    $this->requestVariables = array_merge($this->requestVariables, $this->getVariables);
                    break;

                case 'p':
                    $this->requestVariables = array_merge($this->requestVariables, $this->postVariables);
                    break;
            }

            $requestOrder = substr($requestOrder, 1);
        }
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
        if (!isset($this->serverVariables['PATH_INFO'])) {
            $lastSlash = strrpos($this->serverVariables['SCRIPT_NAME'], '/');
            $currentPath = current(explode('?', $this->serverVariables['REQUEST_URI'], 2));

            return $lastSlash === 0 ? substr($currentPath, 1) : substr($currentPath, $lastSlash+1);
        } else {
            return substr($this->serverVariables['PATH_INFO'], 1);
        }
    }

    /**
     * Gets the path of the URI
     *
     * @return string The path
     */
    public function getPath()
    {
        return $this->path;
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
     * Gets the request variables
     *
     * @return array The request variables
     */
    public function getRequestVariables()
    {
        return $this->requestVariables;
    }

    /**
     * Gets a request variable
     *
     * @return mixed The request variable value (or null if it doesn't exists)
     */
    public function getRequestVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->requestVariables) ? $this->requestVariables[$key] : $defaultValue);
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
        return !(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off');
    }
}