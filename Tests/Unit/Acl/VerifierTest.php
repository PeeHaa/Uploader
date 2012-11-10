<?php

use RichUploaderTest\Mocks\Storage\Session,
    RichUploader\Acl\Verifier;

class VerifierTest extends PHPUnit_Framework_TestCase
{
    protected $roles;
    protected $rolesWithCustomGuest;
    protected $sessionDataUser;
    protected $sessionDataAdmin;
    protected $sessionDataSuperAdmin;

    protected function setUp()
    {
        $this->roles                 = \RichUploaderTest\getTestDataFromFile('roles.php');
        $this->rolesWithCustomGuest  = \RichUploaderTest\getTestDataFromFile('roles-with-custom-guest.php');
        $this->sessionDataUser       = \RichUploaderTest\getTestDataFromFile('session-auth-user.php');
        $this->sessionDataAdmin      = \RichUploaderTest\getTestDataFromFile('session-auth-admin.php');
        $this->sessionDataSuperAdmin = \RichUploaderTest\getTestDataFromFile('session-auth-superadmin.php');
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     */
    public function testAddRolesWithInvalidValueForAccesslevel()
    {
        $roles = $this->roles;
        $roles['user']['accesslevel'] = 'foo';

        $this->setExpectedException('\DomainException');

        $verifier = new Verifier(new Session());
        $verifier->addRoles($roles);
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     */
    public function testAddRolesWithoutAccesslevel()
    {
        $roles = $this->roles;
        unset($roles['user']['accesslevel']);

        $this->setExpectedException('\DomainException');

        $verifier = new Verifier(new Session());
        $verifier->addRoles($roles);
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     */
    public function testAddRolesWithoutStandardGuestRole()
    {
        $roles = $this->roles;
        unset($roles['guest']);

        $this->setExpectedException('\DomainException');

        $verifier = new Verifier(new Session());
        $verifier->addRoles($roles);
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     */
    public function testAddRolesWithoutCustomGuestRole()
    {
        $this->setExpectedException('\DomainException');

        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->roles);
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     */
    public function testAddRolesWhenValidWithStandardGuestRole()
    {
        $verifier = new Verifier(new Session());
        $this->assertSame(null, $verifier->addRoles($this->roles));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     */
    public function testAddRolesWhenValidWithCustomGuestRole()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $this->assertSame(null, $verifier->addRoles($this->rolesWithCustomGuest));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithStandardGuestFalse()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertEquals(false, $verifier->doesRoleMatch('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithCustomGuestFalse()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(false, $verifier->doesRoleMatch('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithStandardGuestTrue()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertEquals(true, $verifier->doesRoleMatch('guest'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithCustomGuestTrue()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(true, $verifier->doesRoleMatch('custom-guest-role'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithCustomRoleFalse()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(false, $verifier->doesRoleMatch('admin'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithCustomRoleTrue()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatch('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithStandardGuestFromCacheFalse()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $verifier->doesRoleMatch('guest');
        $this->assertSame(false, $verifier->doesRoleMatch('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchWithStandardGuestFromCacheTrue()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $verifier->doesRoleMatch('guest');
        $this->assertSame(true, $verifier->doesRoleMatch('guest'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::doesRoleMatch
     */
    public function testDoesRoleMatchThrowsExceptionForUnknownRole()
    {
        $this->setExpectedException('\DomainException');

        $verifier = new Verifier(new Session($this->sessionDataSuperAdmin));
        $verifier->addRoles($this->roles);
        $verifier->doesRoleMatch('admin');
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelUserEquals()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMinimumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelUserMinimum()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMinimumAccesslevel('guest'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelUserFails()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(false, $verifier->doesRoleMatchMinimumAccesslevel('admin'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelStandardGuestEquals()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMinimumAccesslevel('guest'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelStandardGuestMinimum()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMinimumAccesslevel('nobody'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelStandardGuestFails()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertSame(false, $verifier->doesRoleMatchMinimumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelCustomGuestEquals()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(true, $verifier->doesRoleMatchMinimumAccesslevel('custom-guest-role'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelCustomGuestMinimum()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(true, $verifier->doesRoleMatchMinimumAccesslevel('nobody'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMinimumAccesslevel
     */
    public function testDoesRoleMatchMinimumAccesslevelCustomGuestFails()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(false, $verifier->doesRoleMatchMinimumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelUserEquals()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMaximumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelUserMaximum()
    {
        $verifier = new Verifier(new Session($this->sessionDataUser));
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMaximumAccesslevel('admin'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelUserFails()
    {
        $verifier = new Verifier(new Session($this->sessionDataAdmin));
        $verifier->addRoles($this->roles);
        $this->assertSame(false, $verifier->doesRoleMatchMaximumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelStandardGuestEquals()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMaximumAccesslevel('guest'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelStandardGuestMaximum()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertSame(true, $verifier->doesRoleMatchMaximumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelStandardGuestFails()
    {
        $verifier = new Verifier(new Session());
        $verifier->addRoles($this->roles);
        $this->assertSame(false, $verifier->doesRoleMatchMaximumAccesslevel('nobody'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelCustomGuestEquals()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(true, $verifier->doesRoleMatchMaximumAccesslevel('custom-guest-role'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelCustomGuestMaximum()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(true, $verifier->doesRoleMatchMaximumAccesslevel('user'));
    }

    /**
     * @covers Verifier::__construct
     * @covers Verifier::addRoles
     * @covers Verifier::getUserRole
     * @covers Verifier::getAccesslevelOfRole
     * @covers Verifier::doesRoleMatchMaximumAccesslevel
     */
    public function testDoesRoleMatchMaximumAccesslevelCustomGuestFails()
    {
        $verifier = new Verifier(new Session(), 'custom-guest-role');
        $verifier->addRoles($this->rolesWithCustomGuest);
        $this->assertSame(false, $verifier->doesRoleMatchMaximumAccesslevel('nobody'));
    }
}