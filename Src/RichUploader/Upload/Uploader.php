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

        $this->uploadHandler = new Xhr($this->request->getPathVariable('filename'), 'qqfile');
        return;

        if (isset($_GET['qqfile'])) {
            $this->uploadHandler = new qqUploadedFileXhr($filename, 'qqfile');
        } elseif (isset($_FILES['qqfile'])) {
            $this->uploadHandler = new qqUploadedFileForm();
        } else {
            $this->uploadHandler = false;
        }
    }

    /**
     * Checks whether the server settings are sufficient
     *
     * @param array $allowedExtensions List of blocked extensions
     * @param int   $sizeLimit         Maximum size of upload (default is 512MB)
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

    public function getUploadName(){
        if (isset($this->uploadName)) {
            return $this->uploadName;
        }
    }

    public function getName(){
        if ($this->uploadHandler) {
            return $this->file->getName();
        }
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
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
        //$filename = md5(uniqid());
        $ext = @$pathinfo['extension']; // hide notices if extension is empty

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