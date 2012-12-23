<?php
/**
 * Part of the model layer that takes of files on the system
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
    Application\Models\Tag,
    RichUploader\FileSystem\FileFactory;

/**
 * Part of the model layer that takes of files on the system
 *
 * @todo       Add extra layer for storage abstraction
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class File
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
     * @var \Application\Models\Tag Instance of the tag model
     */
    private $tagModel;

    /**
     * @var string The data directory
     */
    private $dataDirectory;

    /**
     * Creates instance
     *
     * @param \PDO                                 $dbConnection  The database connection
     * @param \Application\Models\User             $userModel     The user model
     * @param \Application\Models\Tag              $tagModel      The tag model
     * @param string                               $dataDirectory The directory in which all uploads are stored
     */
    public function __construct(\PDO $dbConnection, User $userModel, Tag $tagModel, $dataDirectory)
    {
        $this->dbConnection  = $dbConnection;
        $this->userModel     = $userModel;
        $this->tagModel      = $tagModel;
        $this->dataDirectory = $dataDirectory;
    }

    /**
     * Gets the (paginated) files of the current logged in user
     *
     * @return array The parsed downlaods
     */
    public function getFilesOfCurrentUser()
    {
        $query = 'SELECT uploads.uploadid, uploads.filename, uploads.timestamp, count(downloads.downloadid) as downloadcount';
        $query.= ' FROM uploads';
        $query.= ' LEFT JOIN downloads ON downloads.uploadid = uploads.uploadid';
        $query.= ' WHERE uploads.userid = :userid';
        $query.= ' GROUP BY uploads.uploadid, uploads.filename, uploads.timestamp';
        $query.= ' ORDER BY uploads.uploadid DESC';
        $query.= ' LIMIT 10 OFFSET 0';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            ':userid' => $this->userModel->getLoggedInUserId(),
        ]);
        $recordset = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $this->parseUploadsRecordset($recordset);
    }

    /**
     * Gets all the info about a file based on id
     *
     * @param int $uploadId The upload id
     *
     * @return array The file info
     */
    public function getFileById($uploadId)
    {
        $query = 'SELECT uploads.uploadid, uploads.filename, uploads.timestamp';
        $query.= ' FROM uploads';
        $query.= ' WHERE uploads.uploadid = :uploadid';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'uploadid' => $uploadId,
        ]);

        $recordset = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$recordset) {
            return [];
        }

        $upload = $this->parseUploadsRecordset($recordset);
        return reset($upload);
    }

    /**
     * Parses a recordset of uploads
     *
     * @param array $recordset The recordset to parse
     *
     * @return array The parsed recordset
     */
    private function parseUploadsRecordset($recordset)
    {
        if (!$recordset) {
            return [];
        }

        $parsedRecordset = [];
        foreach ($recordset as $record) {
            $record['tags'] = [];
            $parsedRecordset[$record['uploadid']] = $record;
        }

        return $this->tagModel->getTagsOfUploadsRecordset($parsedRecordset);
    }

    /**
     * Removes a file from the database and deletes the file when it is the only entry with this hash
     *
     * @param int                                  $uploadId    The id of the upload to be removed
     * @param \RichUploader\FileSystem\FileFactory $fileFactory Interface of the file factory
     *
     * @return boolean Whether the removal was successful
     */
    public function deleteByid($uploadId, FileFactory $fileFactory)
    {
        $query = 'SELECT matches.uploadid, matches.filename, uploads.checksum';
        $query.= ' FROM uploads';
        $query.= ' LEFT JOIN uploads as matches ON uploads.checksum = matches.checksum';
        $query.= ' WHERE uploads.uploadid = :uploadid';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'uploadid' => $uploadId,
        ]);

        $recordset = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->dbConnection->beginTransaction();

        $stmt = $this->dbConnection->prepare('DELETE FROM uploads WHERE uploadid = :uploadid');
        $stmt->execute([
            'uploadid' => $uploadId,
        ]);

        $result = true;
        if (count($recordset) == 1) {
            $fileInfo = new \SplFileInfo($recordset[0]['filename']);
            $file = $fileFactory->build($this->dataDirectory . '/' . substr($recordset[0]['checksum'], 0, 2) . '/' . $recordset[0]['checksum'] . ($fileInfo->getExtension() ? '.' . $fileInfo->getExtension() : ''));

            $result = $file->delete();
        }

        if ($result === true) {
            $this->dbConnection->commit();
            return true;
        }

        $this->dbConnection->rollBack();
        return false;
    }
}