<?php
/**
 * Main class which handles file uploads
 *
 * PHP version 5.4
 *
 * @category   RichUploader
 * @package    Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace RichUploader\Upload;

/**
 * Main class which handles file uploads
 *
 * @category   Yadeo
 * @package    Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Uploadable
{
    /**
     * Saves the file to the specified path
     *
     * @param path The path to save the file to
     *
     * @return boolean true on success
     */
    public function save($path);

    /**
     * Gets the name of the file
     *
     * @return string The name of the file
     */
    public function getName();

    /**
     * Gets the size of the file
     *
     * @return int The size of the file
     */
    public function getSize();
}