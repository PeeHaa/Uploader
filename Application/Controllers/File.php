<?php
/**
 * User controller
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Controllers;

use Application\Views\Files\Overview,
    Application\Views\Files\EditPopup,
    Application\Views\Files\Edit,
    Application\Models\File as FileModel,
    RichUploader\Http\RequestData,
    RichUploader\Security\CsrfToken,
    Application\Views\Files\Delete,
    Application\Views\Files\Download,
    Application\Views\Files\DownloadFile,
    Application\Views\Files\PasswordVerify;

/**
 * User controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class File
{
    /**
     * Sets up the files list view
     *
     * @param \Application\Views\Files\Overview $view         The files list view
     *
     * @return string The rendered view
     */
    public function overview(Overview $view)
    {
        return $view;
    }

    /**
     * Sets up the file edit view
     *
     * @param \Application\Views\Files\EditPopup $view         The file edit view
     *
     * @return string The rendered view
     */
    public function editPopup(EditPopup $view)
    {
        return $view;
    }

    /**
     * Processes the edit of a file
     *
     * @param \Application\Views\Files\Edit  $view         The results view of the edit
     * @param \RichUploader\Http\RequestData $request      The HTTP request data
     * @param \Application\Models\File       $fileModel    The file model
     * @param \RichUploader\Security\CsrfToken; $csrfToken The csrf token
     *
     * @return string The rendered result
     */
    public function edit(Edit $view, RequestData $request, FileModel $fileModel, CsrfToken $csrfToken)
    {
        if (!$csrfToken->validate($request->getPostVariable('csrf-token'))) {
            $view->setResult(['errors' => ['csrf-token']]);
        } else {
            $view->setResult($fileModel->update($request->getPathVariable('id'), $request->getPostVariables()));
        }

        return $view;
    }

    /**
     * Deletes the file of the user
     *
     * @param \Application\Views\Files\Delete $view The delete file view
     *
     * @return string The rendered view
     */
    public function delete(Delete $view)
    {
        return $view;
    }

    /**
     * Displays the download page
     *
     * @param \Application\Views\Files\Download $view The download file view
     *
     * @return string The rendered view
     */
    public function download(Download $view)
    {
        return $view;
    }

    /**
     * Downloads the file
     *
     * @param \Application\Views\Files\DownloadFile $view The download file view
     *
     * @return string The rendered view
     */
    public function downloadFile(DownloadFile $view)
    {
        return $view;
    }

    /**
     * Gets the result of the password verification of the download
     *
     * @param \Application\Views\Files\PasswordVerify $view The result of the password verification
     *
     * @return string The rendered view
     */
    public function verifyPassword(PasswordVerify $view)
    {
        return $view;
    }
}