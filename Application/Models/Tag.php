<?php
/**
 * Part of the model layer that takes of tags of files
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

/**
 * Part of the model layer that takes of tags of files
 *
 * @todo       Add extra layer for storage abstraction
 *
 * @category   Application
 * @package    Models
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Tag
{
    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * Creates instance
     *
     * @param \PDO                                 $dbConnection  The database connection
     */
    public function __construct(\PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Gets the tags belonging to uploads based on their ids
     *
     * @param array $recordset An recordset containing the uploads
     *
     * @return array The recordset containing the uploads including the tags
     */
    public function getTagsOfUploadsRecordset(array $recordset)
    {
        $uploadIds = $this->getIdsOfUploadsRecordset($recordset);

        $query = 'SELECT uploads_tags.uploadid, tags.name';
        $query.= ' FROM tags';
        $query.= ' INNER JOIN uploads_tags ON uploads_tags.tagid = tags.tagid';
        $query.= ' WHERE uploads_tags.uploadid IN (' . implode(',', array_fill(0, count($uploadIds), '?')) . ')';
        $query.= ' ORDER BY uploads_tags.uploadid ASC';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute($uploadIds);

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $record) {
            $recordset[$record['uploadid']]['tags'][] = $record['name'];
        }

        return $recordset;
    }

    /**
     * Gets the ids of uploads from a recordset with uploads
     *
     * @param array $recordset The recordset containing the ids
     *
     * @return array The ids of the uploads
     */
    private function getIdsOfUploadsRecordset(array $recordset)
    {
        $ids = [];
        foreach ($recordset as $record) {
            $ids[] = $record['uploadid'];
        }

        return $ids;
    }
}