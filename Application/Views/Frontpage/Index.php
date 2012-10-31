<?php
/**
 * Frontpage view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Frontpage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Frontpage;

use Application\Views\BaseView,
    Application\Models\User;

/**
 * Frontpage view
 *
 * @category   Application
 * @package    Views
 * @subpackage Frontpage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Index extends BaseView
{
    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * Creates instance
     *
     * @param \Application\Models\User $userModel The user model
     */
    public function __construct(\Application\Models\User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        return $this->renderTemplate('base/page.phtml');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
    }
}