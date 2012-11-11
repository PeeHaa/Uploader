<?php
/**
 * Part of the model layer that takes care of uploads
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
    RichUploader\FileSystem\File;

/**
 * Part of the model layer that takes care of uploads
 *
 * @todo       Add extra layer for storage abstraction
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Upload
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
     * @param \RichUploader\FileSystem\FileFactory $fileFactory   The file factory
     * @param string                               $dataDirectory The data directory
     */
    public function __construct(\PDO $dbConnection, User $userModel, FileFactory $fileFactory, $dataDirectory)
    {
        $this->dbConnection  = $dbConnection;
        $this->userModel     = $userModel;
        $this->fileFactory   = $fileFactory;
        $this->dataDirectory = $dataDirectory;
    }

    /**
     * Processes the uploaded file
     *
     * @param string $temporaryFilename The location of the temporary file
     */
    public function process($temporaryFilename)
    {
        $file = $this->fileFactory->build($temporaryFilename);

        $checksum = $file->getSha1Checksum();

        if (!$this->doesFileExist($checksum)) {
            $this->moveFile($file, $checksum);
        }

        $stmt = $this->dbConnection->prepare(
            'INSERT INTO uploads (filename, userid, checksum) VALUES (:filename, :userid, :checksum)'
        );
        $stmt->execute([
            'filename' => $temporaryFilename,
            'userid'   => $this->userModel->getLoggedInUserId(),
            'checksum' => $checksum,
        ]);
    }

    /**
     * Checks whether the file is already uploaded based on the sha1 hash
     *
     * @param string $checksum The checksum of the file
     *
     * @return boolean Whether the file exists
     */
    private function doesFileExist($checksum)
    {
        $stmt = $this->dbConnection->prepare('SELECT uploadid FROM uploads WHERE checksum = :checksum');
        $stmt->execute([
            'checksum' => $checksum,
        ]);
        $recordset = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($recordset) {
            return true;
        }

        return false;
    }

    /**
     * Moves the file to its final destination (sha1 hash of file with extension. In a directory with a name starting
     * with the first two digits of the hash)
     *
     * @param \RichUploader\FileSystem\File $file     The instance of the uploaded file
     * @param string                        $checksum The checksum of the file
     */
    private function moveFile(File $file, $checksum)
    {
        $uploadDirectory = $this->dataDirectory . '/' . substr($checksum, 0, 2);

        $file->rename($checksum . ($file->getExtension() ? '.' . $file->getExtension() : ''));

        $file->move($uploadDirectory);
    }
}