<?php
/**
 * Login view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage User
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\User;

use Application\Views\BaseView,
    Application\Models\User;

/**
 * Login view
 *
 * @category   Application
 * @package    Views
 * @subpackage User
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Login extends BaseView
{
    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * @var string The supplied username
     */
    private $username;

    /**
     * @var string The supplied password
     */
    private $password;

    /**
     * Creates instance
     *
     * @param \Application\Models\User $userModel The user model
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Sets the supplied username
     *
     * @param string $username The supplied username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Sets the supplied password
     *
     * @param string $password The supplied password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        return $this->renderTemplate('user/login.phtml');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['result'] = $this->userModel->login($this->username, $this->password);
    }
}