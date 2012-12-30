<?php
/**
 * Handles uploaded files by "normal" form requests
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

use RichUploader\Upload\Uploadable;

/**
 * Handles uploaded files by "normal" form requests
 *
 * @category   Yadeo
 * @package    Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Form implements Uploadable
{
    /**
     * @var array The request parameters
     */
    private $requestParameters;

    /**
     * @var string The name of the file inputfield
     */
    private $inputName;

    /**
     * @var string The filename of the uploaded file
     */
    private $filename;

    /**
     * Creates instance
     *
     * @param array  $requestParameters The parameters of the request
     * @param string $inputName         The name of the field containing the file
     *
     * @return boolean TRUE on success
     */
    public function __construct($filename, $inputName)
    {
        $this->filename          = $filename;
        $this->inputName         = $inputName;
    }

    /**
     * Saves the file to the specified path
     *
     * @param path The path to save the file to
     *
     * @return boolean true on success
     */
    public function save($path)
    {
        return move_uploaded_file($_FILES[$this->inputName]['tmp_name'], $path);
    }

    /**
     * Gets the name of the file
     *
     * @return string The name of the file
     */
    public function getName()
    {
        return $_FILES[$this->inputName]['name'];
    }

    /**
     * Gets the size of the file
     *
     * @return int The size of the file
     */
    public function getSize()
    {
        return $_FILES[$this->inputName]['size'];
    }
}