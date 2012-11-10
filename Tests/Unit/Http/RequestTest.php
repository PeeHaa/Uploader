<?php

use RichUploader\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
    protected $serverVariables;
    protected $getVariables;
    protected $postVariables;
    protected $mapping;
    protected $mappingFailed;

    public function setUp()
    {
        $this->serverVariables = \RichUploaderTest\getTestDataFromFile('server-variables.php');
        $this->getVariables    = \RichUploaderTest\getTestDataFromFile('get-variables.php');
        $this->postVariables   = \RichUploaderTest\getTestDataFromFile('post-variables.php');
        $this->mapping         = \RichUploaderTest\getTestDataFromFile('request-mapper.php');
        $this->mappingFailed   = \RichUploaderTest\getTestDataFromFile('request-mapper-fail.php');
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPath
     */
    public function testGetPath()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertEquals('/some/deep/path', $request->getPath());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::setPathVariables
     */
    public function testSetPathVariablesThrowsExceptionForInvalidMappingCount()
    {
        $this->setExpectedException('\UnexpectedValueException');

        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $request->setPathVariables($this->mappingFailed);
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::setPathVariables
     */
    public function testSetPathVariablesSuccess()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(null, $request->setPathVariables($this->mapping));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getGetVariables
     */
    public function testGetGetVariables()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame($this->getVariables, $request->getGetVariables());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getGetVariable
     */
    public function testGetGetVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('value1', $request->getGetVariable('var1'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getGetVariable
     */
    public function testGetGetVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(null, $request->getGetVariable('var99'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getGetVariable
     */
    public function testGetGetVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('nonDefault', $request->getGetVariable('var99', 'nonDefault'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPostVariables
     */
    public function testGetPostVariables()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame($this->postVariables, $request->getPostVariables());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPostVariable
     */
    public function testGetPostVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('postvalue1', $request->getPostVariable('postvar1'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPostVariable
     */
    public function testGetPostVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(null, $request->getPostVariable('postvar99'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPostVariable
     */
    public function testGetPostVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('nonDefault', $request->getPostVariable('postvar99', 'nonDefault'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPathVariables
     */
    public function testGetPathVariablesWithoutMapping()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame([], $request->getPathVariables());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPathVariables
     */
    public function testGetPathVariablesWithMapping()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $request->setPathVariables($this->mapping);
        $this->assertSame(['first_var' => 'some', 'second_var' => 'deep'], $request->getPathVariables());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPathVariable
     */
    public function testGetPathVariableWithKnownVariable()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $request->setPathVariables($this->mapping);
        $this->assertSame('some', $request->getPathVariable('first_var'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPathVariable
     */
    public function testGetPathVariableWithUnknownVariableDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(null, $request->getPostVariable('unknown_var'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getPathVariable
     */
    public function testGetPathVariableWithUnknownVariableNotDefault()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('nonDefault', $request->getPathVariable('unknown_var', 'nonDefault'));
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getMethod
     */
    public function testGetMethod()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('POST', $request->getMethod());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::getHost
     */
    public function testGetHost()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame('www.example.com', $request->getHost());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::isSsl
     */
    public function testIsSslWithOn()
    {
        $request = new Request($this->serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(true, $request->isSsl());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::isSsl
     */
    public function testIsSslWithOff()
    {
        $serverVariables = $this->serverVariables;
        $serverVariables['HTTPS'] = 'off';

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(false, $request->isSsl());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::isSsl
     */
    public function testIsSslWithoutValue()
    {
        $serverVariables = $this->serverVariables;
        $serverVariables['HTTPS'] = '';

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(false, $request->isSsl());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::isSsl
     */
    public function testIsSslWithSomeString()
    {
        $serverVariables = $this->serverVariables;
        $serverVariables['HTTPS'] = 'somerandomstring';

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(true, $request->isSsl());
    }

    /**
     * @covers Request::__construct
     * @covers Request::setPath
     * @covers Request::getBarePath
     * @covers Request::isSsl
     */
    public function testIsSslWithoutHttpsKey()
    {
        $serverVariables = $this->serverVariables;
        unset($serverVariables['HTTPS']);

        $request = new Request($serverVariables, $this->getVariables, $this->postVariables);
        $this->assertSame(false, $request->isSsl());
    }
}