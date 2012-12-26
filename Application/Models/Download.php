<?php
/**
 * Part of the model layer that takes care of downloads
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Models;

use Application\Models\User,
    RichUploader\FileSystem\FileFactory,
    Application\Models\File;

/**
 * Part of the model layer that takes care of downloads
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Download
{
    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * @var \Application\Models\User Instance of the user model
     */
    private $userModel;

    /**
     * @var \Application\Models\File Instance of the file model
     */
    private $fileModel;

    /**
     * @var \RichUploader\FileSystem\FileFactory The file factory
     */
    private $fileFactory;

    /**
     * @var string The data directory (where all the uploads will get stored)
     */
    private $dataDirectory;

    /**
     * Creates instance
     *
     * @param \PDO                                 $dbConnection  The database connection
     * @param \Application\Models\User             $session       The session
     * @param \Application\Models\File             $fileModel     The file model
     * @param \RichUploader\FileSystem\FileFactory $fileFactory   The file factory
     * @param string                               $dataDirectory The data directory
     */
    public function __construct(\PDO $dbConnection, User $userModel, File $fileModel, FileFactory $fileFactory, $dataDirectory)
    {
        $this->dbConnection  = $dbConnection;
        $this->userModel     = $userModel;
        $this->fileModel     = $fileModel;
        $this->fileFactory   = $fileFactory;
        $this->dataDirectory = $dataDirectory;
    }

    /**
     * Gets the information about a file to be downloaded
     *
     * @param int $id The id of the file to be downloaded
     *
     * @return array Array with the fileinfo, the accesslevel and possibly errors
     */
    public function getFileForDownload($id)
    {
        $file = $this->fileModel->getFileById($id);

        $file['size'] = $this->getFileSize($file['checksum'], $file['filename']);

        switch($file['access']) {
            case 'private':
                //$this->userModel->getLoggedInUserId();
                break;

            case 'public':
                return [
                    'errors' => false,
                    'access' => 'public',
                    'file'   => $file,
                ];

            case 'password':
                break;
        }
    }

    /**
     * Gets the size of a file
     *
     * @param string $checksum The checksum of the file
     * @param string $filename The filename
     *
     * @return int The size of the file in bytes
     */
    private function getFileSize($checksum, $filename)
    {
        $file = $this->fileFactory->build($this->fileModel->getFullPath($checksum, $filename));

        return $file->getSize();
    }
}