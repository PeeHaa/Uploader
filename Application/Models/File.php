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
    Application\Models\Tag;

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
     * Creates instance
     *
     * @param \PDO                                 $dbConnection  The database connection
     * @param \Application\Models\User             $userModel     The user model
     * @param \Application\Models\Tag              $tagModel      The tag model
     */
    public function __construct(\PDO $dbConnection, User $userModel, Tag $tagModel)
    {
        $this->dbConnection  = $dbConnection;
        $this->userModel     = $userModel;
        $this->tagModel      = $tagModel;
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
}