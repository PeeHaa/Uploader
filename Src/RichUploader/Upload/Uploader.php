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

use RichUploader\Upload\Xhr,
    RichUploader\Upload\Form,
    RichUploader\Http\Request;

/**
 * Main class which handles file uploads
 *
 * @category   Yadeo
 * @package    Upload
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Uploader
{
    /**
     * @var array List of blocked extensions
     */
    private $blockedExtensions = array();

    /**
     * @var int The maximum allowed size in bytes (default is 512MB)
     */
    private $sizeLimit = 536870912;

    /**
     * @var \RichUploader\Upload\Uploadable The instance of the upload class
     */
    private $uploadHandler;

    /**
     * @var string The upload name
     */
    private $uploadName;

    /**
     * @var \RichUploader\Http\Request The request object
     */
    private $request;

    /**
     * Creates an instance
     *
     * @param \RichUploader\Http\Request The request object
     * @param array $allowedExtensions List of blocked extensions
     * @param int   $sizeLimit         Maximum size of upload (default is 512MB)
     */
    public function __construct($request, array $blockedExtensions = array(), $sizeLimit = 536870912){
        $this->request           = $request;
        $this->blockedExtensions = array_map('strtolower', $blockedExtensions);
        $this->sizeLimit         = $sizeLimit;

        $this->validateServerSettings();

        if ($this->request->getPathVariable('filename', false) !== false) {
            $this->uploadHandler = new Xhr($this->request->getPathVariable('filename'), 'qqfile');
        } elseif (isset($_FILES['qqfile'])) {
            $this->uploadHandler = new Form($_FILES['qqfile']['name'], 'qqfile');
        } else {
            $this->uploadHandler = false;
        }
    }

    /**
     * Checks whether the server settings are sufficient
     */
    private function validateServerSettings()
    {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

    /**
     * Converts human readable byte sizes to bytes
     *
     * @param str $str The human readable byte size
     *
     * @return string The size in bytes
     */
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Gets the name of the uploaded file
     *
     * @return null|string The name of the upload when set or null otherwise
     */
    public function getUploadName(){
        if (isset($this->uploadName)) {
            return $this->uploadName;
        }
    }

    /**
     * Gets the actual filename of the uploaded file
     *
     * @return null|string The name of the upload when set or null otherwise
     */
    public function getName(){
        if ($this->uploadHandler) {
            return $this->file->getName();
        }
    }

    /**
     * Processes the upload if the file to the server
     *
     * @param string  $uploadDirectory The full path to the directory to which to save the upload
     * @param boolean $replaceOldFile  Whether the old file can replaced if it is the same file
     *
     * @return array array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = true){
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->uploadHandler){
            return array('error' => 'No files were uploaded.');
        }

        $size = $this->uploadHandler->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }

        $pathinfo = pathinfo($this->uploadHandler->getName());
        $filename = $pathinfo['filename'];

        $ext = @$pathinfo['extension'];

        if($this->blockedExtensions && in_array(strtolower($ext), $this->blockedExtensions)){
            $these = implode(', ', $this->blockedExtensions);
            return array('error' => 'File has an invalid extension. Blocked extensions are '. $these . '.');
        }

        $ext = ($ext == '') ? $ext : '.' . $ext;

        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        $this->uploadName = $filename . $ext;

        if ($this->uploadHandler->save($uploadDirectory . '/' . $filename . $ext)){
            return array(
                'success'=>true,
            );
        } else {
            return array(
                'error'=> 'Could not save uploaded file. The upload was cancelled, or server error encountered',
            );
        }
    }
}