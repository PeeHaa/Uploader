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
namespace RichUploaderTest\Mocks\Http;

use RichUploader\Http\RequestData;

class Request implements RequestData
{
    protected $requestData = [];

    public function __construct(array $requestData)
    {
        $this->requestData  = $requestData;
    }

    public function getPath()
    {
        return $this->requestData['path'];
    }

    public function setPathVariables(array $mapping)
    {
    }

    public function getGetVariables()
    {
        return $this->requestData['getVariables'];
    }

    public function getGetVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->requestData['getVariables']) ? $this->requestData['getVariables'][$key] : $defaultValue);
    }

    public function getPostVariables()
    {
        return $requestData['postVariables'];
    }

    public function getPostVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->requestData['postVariables']) ? $this->requestData['postVariables'][$key] : $defaultValue);
    }

    public function getPathVariables()
    {
        return $this->requestData['pathVariables'];
    }

    public function getPathVariable($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->requestData['pathVariables']) ? $this->requestData['pathVariables'][$key] : $defaultValue);
    }

    public function getMethod()
    {
        return $this->requestData['method'];
    }

    public function getHost()
    {
        return $this->requestData['host'];
    }

    public function isSsl()
    {
        return $this->requestData['ssl'];
    }
}