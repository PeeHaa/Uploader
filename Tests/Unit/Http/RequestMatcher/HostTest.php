<?php

use RichUploaderTest\Mocks\Http\Request,
    RichUploader\Http\RequestMatcher\Host;

class HostTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExact()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#^www\.example\.com$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactGrouped()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#^(www\.example\.com)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactFail()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#^www\.examples\.com$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactGroupedFail()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#^(www\.examples\.com)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWith()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#^www#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWithGrouped()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#^(www)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWithFailed()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#^w3#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWithGroupedFailed()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#^(w3)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWith()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#\.com$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWithGrouped()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#(\.com)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWithFailed()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#\.nl$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWithGroupedFailed()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#(\.nl)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContains()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#example#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsGrouped()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#(example)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultiple()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#e#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleGrouped()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#(e)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleDifferent()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#(e|x)|\.com#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleDifferentOneOfExpression()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(true, $hostTest->doesMatch('#(e|x)|\.nl#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleDifferentFailedOnNeitherOfExpression()
    {
        $request = new Request(['host' => 'www.example.com']);
        $hostTest = new Host($request);

        $this->assertSame(false, $hostTest->doesMatch('#(v|f)|\.nl#'));
    }
}