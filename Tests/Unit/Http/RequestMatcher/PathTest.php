<?php

use RichUploaderTest\Mocks\Http\Request,
    RichUploader\Http\RequestMatcher\Path;

class PathTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExact()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/some/deep/path/with/some/var/in/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactGrouped()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^(/some/deep/path/with/some/var/in/it)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactFail()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#^/some/deep/paths/with/some/var/in/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactGroupedFail()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#^(/some/deep/paths/with/some/var/in/it)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWith()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/some/deep/path/#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWithGrouped()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^(/some/deep/path/)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWithFailed()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#^/some/deep/paths/#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchStartsWithGroupedFailed()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#^(/some/deep/paths/)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWith()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#/in/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWithGrouped()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#(/in/it)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWithFailed()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#/out/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchEndsWithGroupedFailed()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#(/out/it)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContains()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#with/some#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsGrouped()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#(with/some)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultiple()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#e#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleGrouped()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#(e)#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleDifferent()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#(e|x)|/in/#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleDifferentOneOfExpression()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#(e|x)|\.nl#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleDifferentFailedOnNeitherOfExpression()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(false, $pathTest->doesMatch('#(l|x)|\.nl#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsVariable()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/some/deep/path/with/some/(.*)/in/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleVariables()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/some/deep/path/(.*)/some/(.*)/in/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchContainsMultipleVariablesGrouped()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^(/some/deep/path/(.*)/some/(.*)/in/it)$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchWithOptionalStartingSlash()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/?some/deep/path/with/some/var/in/it$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchWithOptionalTrailingSlash()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/some/deep/path/with/some/var/in/it/?$#'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchWithOptionalStartingAndTrailingSlashes()
    {
        $request = new Request(['path' => '/some/deep/path/with/some/var/in/it']);
        $pathTest = new Path($request);

        $this->assertSame(true, $pathTest->doesMatch('#^/?some/deep/path/with/some/var/in/it/?$#'));
    }
}