<?php

use RichUploaderTest\Mocks\Acl\Verifier,
    RichUploader\Http\RequestMatcher\Permissions;

class PermissionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExact()
    {
        $verifier        = new Verifier(['match' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactFail()
    {
        $verifier        = new Verifier(['match' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMinimum()
    {
        $verifier        = new Verifier(['minimum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['minimum' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMinimumFail()
    {
        $verifier        = new Verifier(['minimum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['minimum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMaximum()
    {
        $verifier        = new Verifier(['maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['maximum' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMaximumFail()
    {
        $verifier        = new Verifier(['maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMinimum()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMinimumFailExact()
    {
        $verifier        = new Verifier(['match' => false, 'minimum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMinimumFailMinimum()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMinimumFailBoth()
    {
        $verifier        = new Verifier(['match' => false, 'minimum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMaximum()
    {
        $verifier        = new Verifier(['match' => true, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'maximum' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMaximumFailExact()
    {
        $verifier        = new Verifier(['match' => false, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMaximumFailMaximum()
    {
        $verifier        = new Verifier(['match' => true, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchExactAndMaximumFailBoth()
    {
        $verifier        = new Verifier(['match' => false, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMinimumAndMaximum()
    {
        $verifier        = new Verifier(['minimum' => true, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMinimumAndMaximumFailExact()
    {
        $verifier        = new Verifier(['minimum' => false, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMinimumAndMaximumFailMaximum()
    {
        $verifier        = new Verifier(['minimum' => true, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchMinimumAndMaximumFailBoth()
    {
        $verifier        = new Verifier(['minimum' => false, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAll()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => true, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(true, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailExact()
    {
        $verifier        = new Verifier(['match' => false, 'minimum' => true, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailMinimum()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => false, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailMaximum()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => true, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailExactAndMinimum()
    {
        $verifier        = new Verifier(['match' => false, 'minimum' => false, 'maximum' => true]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailExactAndMaximum()
    {
        $verifier        = new Verifier(['match' => false, 'minimum' => true, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailMinimumAndMaximum()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => false, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailMaximumAndMinimumSwitched()
    {
        $verifier        = new Verifier(['match' => true, 'minimum' => false, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::doesMatch
     */
    public function testDoesMatchAllFailall()
    {
        $verifier        = new Verifier(['match' => false, 'minimum' => false, 'maximum' => false]);
        $permissionsTest = new Permissions($verifier);

        $requirements = ['match' => 'user', 'minimum' => 'user', 'maximum' => 'user'];

        $this->assertSame(false, $permissionsTest->doesMatch($requirements));
    }
}