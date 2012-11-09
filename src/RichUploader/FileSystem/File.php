<?php
/**
 * Class which represents a file
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

/**
 * Class which represents a file
 *
 * @category   RichUploader
 * @package    FileSystem
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class File
{
    /**
     * @var string The full filename including the path
     */
    private $filename;

    /**
     * @var array A list of file types
     */
    private $fileTypes = [];

    /**
     * Create instance
     *
     * @param string $filename The full filename including the path
     */
    public function __construct($filename)
    {
        if (is_dir($filename)) {
            throw new \DomainException('The supplied filename (`' . $filename . '`) is a directory instead of a file.');
        }

        if (!is_readable($filename)) {
            throw new \DomainException('The file (`' . $filename . '`) cannot be read.');
        }

        $this->filename  = $filename;
        $this->fileTypes = $this->getFileTypes();
    }

    /**
     * Gets a list of file types. This list is loaded from an external file in the same directory as this class. It is
     * in an external file to prevent this code tye become unreadable.
     *
     * @return array The file types
     * @throws \DomainException When file is not readable
     */
    private function getFileTypes()
    {
        $filename = __DIR__ . '/mime-types.php';
        if (!is_readable($filename)) {
            throw new \DomainException('Mime types file (`' . $filename . '`) does not exist or is not readable.');
        }

        return $filename;
    }

    /**
     * Gets the SHA1 checksum of the contents of the file
     *
     * @return string The SHA1 checksum of the contents of the file
     */
    public function getSha1Checksum()
    {
        return sha1_file($this->filename);
    }

    /**
     * Gets the MD5 checksum of the contents of the file
     *
     * @return string The MD5 checksum of the contents of the file
     */
    public function getMd5Checksum()
    {
        return md5_file($this->filename);
    }

    /**
     * Gets the filename from the full path
     *
     * @return string The filename
     */
    public function getFilename()
    {
        return pathinfo($this->filename, PATHINFO_BASENAME);
    }

    /**
     * Gets the extension of the file
     *
     * @return string The extension
     */
    public function getExtension()
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    /**
     * Gets the MIME type of the file. Note that currently it only checks for extension so it should not really be
     * trusted in any way since it can easily be fooled.
     *
     * @return string The MIME type
     */
    public function getMimeType()
    {
        if (array_key_exists($this->getExtension(), $this->fileTypes)) {
            return $this->fileTypes[$this->getExtension()]['type'];
        }

        return 'application/octet-stream';
    }

    /**
     * Moves a file to a new location
     *
     * @param string $destination The destination
     *
     * @return \DomainException When the file could not be moved
     */
    public function move($destination)
    {
        if (!is_dir($destination)) {
            $this->createDirectory($destination);
        }

        if (!rename($this->filename, $destination . '/' . $this->getFilename())) {
            throw new \DomainException(
                'File (`' . $this->filename . '`) could not be moved to the destination directory (`' . $destination . '`).'
            );
        }

        $this->filename = $destination . $this->getFilename();
    }

    /**
     * Create a directory
     *
     * @param string $path The directory to create
     *
     * @throws \DomainException When the directory cannot be created
     */
    private function createDirectory($path)
    {
        if (!mkdir($path, 0666)) {
            throw new \DomainException('Directory (`' . $path . '`) could not be created.');
        }
    }
}