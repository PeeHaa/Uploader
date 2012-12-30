<?php
/**
 * Handles uploaded files by XHR requests
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
 * Handles uploaded files by XHR requests
 *
 * @category   Yadeo
 * @package    Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Xhr implements Uploadable
{
    /**
     * @var array The request parameters
     */
    private $requestParameters;

    /**
     * @var string The name of the file inputfield
     */
    private $inputName;

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
        $input = fopen('php://input', 'r');
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);

        if ($realSize != $this->getSize()){
            return false;
        }

        $target = fopen($path, 'w');
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return true;
    }

    /**
     * Gets the name of the file
     *
     * @return string The name of the file
     */
    public function getName()
    {
        return $this->filename;
    }

    /**
     * Gets the size of the file
     *
     * @return int The size of the file
     */
    public function getSize()
    {
        if (isset($_SERVER['CONTENT_LENGTH'])){
            return (int)$_SERVER['CONTENT_LENGTH'];
        } else {
            throw new \Exception('Getting content length is not supported.');
        }
    }
}