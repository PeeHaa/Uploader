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
            throw new \DomainException('The filename (`' . $filename . '`) cannot be read.');
        }

        $this->filename = $filename;
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
        switch ($this->getExtension()) {
            case '3gp':
                return 'video/3gpp';

            case '3g2':
                return 'video/3gpp2';

            case '7z':
                return 'application/x-7z-compressed';

            case 'ace':
                return 'application/x-ace-compressed';

            case 'air':
                return 'application/vnd.adobe.air-application-installer-package+zip';

            case 'swf':
                return 'application/x-shockwave-flash';

            case 'pdf':
                return 'application/pdf';

            case 'aac':
                return 'audio/x-aac';

            case 'azw':
                return 'application/vnd.amazon.ebook';

            case 'case':
                return 'audio/x-aiff';

            case 'avi':
                return 'video/x-msvideo';

            case 'bin':
            default:
                return 'application/octet-stream';
        }
    }
}