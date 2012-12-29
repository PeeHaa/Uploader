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
class DownloadFile extends BaseView
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
     * @var The file to be downloaded
     */
    private $file = null;

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
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->downloadModel->hasUserAccess($this->request->getPathVariable('id'), $this->session) === true) {
            $file = $this->downloadModel->download($this->request->getPathVariable('id'));

            header('Content-Type: application/octet-stream');
            header('Content-Transfer-Encoding: Binary');
            header('Content-disposition: attachment; filename="' . basename($file['filename']) . '"');
            readfile($file['full_path']);
        } else {
            // the shit hits the fan
        }
return;

        // check privileges and whether file exists
        /*
        $file_name = 'file.exe';
        $file_url = 'http://www.myremoteserver.com/' . $file_name;

        */

        $download = $this->downloadModel->getFileForDownload($this->request->getPathVariable('id'));

        if ($download['errors'] === false) {
            $this->file = $download['file'];

            switch($download['access'] == 'public') {

            }
        }

        if ($this->request->getPathVariable('json', false) === false) {
            return $this->renderPage('file/download.phtml');
        }

        return $this->renderTemplate('file/download.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $this->templateVariables['title']          = 'Downloading file: ' . basename($this->file['filename']);
        $this->templateVariables['isUserLoggedIn'] = $this->userModel->isLoggedIn();
        $this->templateVariables['file']           = $this->file;
        $this->templateVariables['download']       = $this->file['uploadid'];
    }
}