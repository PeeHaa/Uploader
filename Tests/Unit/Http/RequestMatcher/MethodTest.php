<?php

use RichUploaderTest\Mocks\Http\Request,
    RichUploader\Http\RequestMatcher\Method;

class MethodTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExact()
    {
        $request = new Request(['method' => 'post']);
        $hostTest = new Method($request);

        $this->assertSame(true, $hostTest->doesMatch('post'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchDifferentCasingArgument()
    {
        $request = new Request(['method' => 'post']);
        $hostTest = new Method($request);

        $this->assertSame(true, $hostTest->doesMatch('POST'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactPut()
    {
        $request = new Request(['method' => 'PUT']);
        $hostTest = new Method($request);

        $this->assertSame(true, $hostTest->doesMatch('put'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchFail()
    {
        $request = new Request(['method' => 'PUT']);
        $hostTest = new Method($request);

        $this->assertSame(false, $hostTest->doesMatch('post'));
    }
}