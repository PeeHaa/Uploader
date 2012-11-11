<?php

use RichUploaderTest\Mocks\Http\Request,
    RichUploader\Http\RequestMatcher\Ssl;

class SslTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEnabled()
    {
        $request = new Request(['ssl' => true]);
        $sslTest = new Ssl($request);

        $this->assertSame(true, $sslTest->doesMatch(true));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEnabledFail()
    {
        $request = new Request(['ssl' => true]);
        $sslTest = new Ssl($request);

        $this->assertSame(false, $sslTest->doesMatch(false));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchDisabled()
    {
        $request = new Request(['ssl' => false]);
        $sslTest = new Ssl($request);

        $this->assertSame(true, $sslTest->doesMatch(false));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchDisabledFail()
    {
        $request = new Request(['ssl' => false]);
        $sslTest = new Ssl($request);

        $this->assertSame(false, $sslTest->doesMatch(true));
    }
}