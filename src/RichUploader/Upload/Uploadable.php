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