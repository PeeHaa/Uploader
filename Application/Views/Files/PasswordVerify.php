<?php
/**
 * Password verify file view
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
    Application\Models\File,
    RichUploader\Storage\SessionInterface;

/**
 * Password verify file view
 *
 * @category   Application
 * @package    Views
 * @subpackage Files
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class PasswordVerify extends BaseView
{
    /**
     * @var \RichUploader\Http\RequestData The request
     */
    private $request;

    /**
     * @var \Application\Models\File The file model
     */
    private $fileModel;

    /**
     * @var \RichUploader\Storage\SessionInterface The session
     */
    private $session;

    /**
     * Creates instance Application\Models\Download
     *
     * @param \RichUploader\Http\RequestData         $request   The request
     * @param \Application\Models\File               $fileModel The download model
     * @param \RichUploader\Storage\SessionInterface $session   The session
     */
    public function __construct(RequestData $request, File $fileModel, SessionInterface $session)
    {
        $this->request   = $request;
        $this->fileModel = $fileModel;
        $this->session   = $session;
    }

    /**
     * Renders the template
     *
     * @return string The rendered HTML
     */
    public function render()
    {
        if ($this->request->getPathVariable('json', false) === false) {
            // redirect to download page
        }

        return $this->renderTemplate('file/download-verify.pjson');
    }

    /**
     * Sets the template variables
     */
    protected function setTemplateVariables()
    {
        $result = $this->fileModel->verifyPassword(
            $this->request->getPathVariable('id'),
            $this->request->getPostVariable('password')
        );

        if ($result === false) {
            $this->templateVariables['result'] = ['result' => 'failed'];
        } else {
            $this->setAccessAsValidated($result['uploadid']);

            $this->templateVariables['result'] = [
                'result'   => 'success',
                'fileInfo' => $result,
                'url' => '/download/' . $result['uploadid'],
            ];
        }
    }

    /**
     * Sets the access of the file
     *
     * @param int $uploadId The id of the file
     */
    private function setAccessAsValidated($uploadId)
    {
        $fileAccessList = [];
        if ($this->session->isKeyValid('fileAccessList')) {
            $fileAccessList = $this->session->get('fileAccessList');
        }

        $fileAccessList[$uploadId] = true;

        $this->session->set('fileAccessList', $fileAccessList);
    }
}