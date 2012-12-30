<?php
/**
 * Download file view
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Views\Files;

use Application\Views\BaseView,
    RichUploader\Http\RequestData,
    Application\Models\Download as DownloadModel,
    Application\Models\User,
    RichUploader\Storage\SessionInterface;

/**
 * Download file view
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Download extends BaseView
{
    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \Application\Models\Download The download model
     */
    private $downloadModel;

    /**
     * @var \Application\Models\User The user model
     */
    private $userModel;

    /**
     * @var \RichUploader\Storage\SessionInterface The session
     */
    private $session;

    /**
     * @var array The info of the downloaded
     */
    private $downloadInfo = null;

    /**
     * @var array The errors
     */
    private $errors = [];

    /**
     * Creates instance Application\Models\Download
     *
     * @param \RichUploader\Http\RequestData         $request       The request
     * @param \Application\Models\Download           $downloadModel The download model
     * @param \Application\Models\User               $userModel     The user model
     * @param \RichUploader\Storage\SessionInterface $session       The session
     */
    public function __construct(RequestData $request, DownloadModel $downloadModel, User $userModel, SessionInterface $session)
    {
        $this->request       = $request;
        $this->downloadModel = $downloadModel;
        $this->userModel     = $userModel;
        $this->session       = $session;
    }

    /**
     * Renders the template
     *
     * @todo The file access lists needs its own class which uses the session storage
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        $this->downloadInfo = $this->downloadModel->getFileForDownload($this->request->getPathVariable('id'));

        if ($this->downloadInfo['file']['userid'] == $this->userModel->getLoggedInUserId()) {
            $this->downloadInfo['action'] = null;
        }

        if ($this->session->isKeyValid('fileAccessList')) {
            $fileAccessList = $this->session->get('fileAccessList');
            if (array_key_exists($this->request->getPathVariable('id'), $fileAccessList)) {
                $this->downloadInfo['action'] = null;
            }
        }

        switch ($this->downloadInfo['action']) {
            case 'needs-login':
                if ($this->request->getPathVariable('json', false) === false) {
                    return $this->renderPage('file/download-requires-login.phtml');
                }

                return $this->renderTemplate('file/download-requires-login.pjson');
                break;

            case 'access-denied':
                if ($this->request->getPathVariable('json', false) === false) {
                    return $this->renderPage('file/download-denied.phtml');
                }

                return $this->renderTemplate('file/download-denied.pjson');

            case 'requires-password':
                if ($this->request->getPathVariable('json', false) === false) {
                    return $this->renderPage('file/download-requires-password.phtml');
                }

                return $this->renderTemplate('file/download-requires-password.pjson');
                break;

            case null:
                if ($this->request->getPathVariable('json', false) === false) {
                    return $this->renderPage('file/download.phtml');
                }

                return $this->renderTemplate('file/download.pjson');
        }
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        switch ($this->downloadInfo['action']) {
            case 'needs-login':
                $this->templateVariables['title'] = 'Login';
                break;

            case 'access-denied':
                $this->templateVariables['title'] = 'Access denied';
                break;

            case 'requires-password':
                $this->templateVariables['title'] = 'Provide password';
                break;

            case null:
            default:
                $this->templateVariables['title'] = 'Downloading file: ' . basename($this->downloadInfo['file']['filename']);
                break;
        }

        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['file']           = $this->downloadInfo['file'];
        if ($this->downloadInfo['action'] === null) {
            $this->templateVariables['download']       = $this->downloadInfo['file']['uploadid'];
        }
    }
}