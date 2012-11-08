<?php
/**
 * Factory which creates instances of the File class
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    FileSystem
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\FileSystem;

use RichUploader\FileSystem\File;

/**
 * Factory which creates instances of the File class
 *
 * @category   RichUploader
 * @package    FileSystem
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class FileFactory
{
    /**
     * Builds an instance of the File class
     *
     * @param string $filename The full filename including the path
     *
     * @return \RichUploader\FileSystem\File Instance of the File class
     */
    public function build($filename)
    {
        return new File($filename);
    }
}