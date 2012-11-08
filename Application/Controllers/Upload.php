<?php
/**
 * Upload controller
 *
 * PHP version 5.4
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Application\Controllers;

use Application\Views\Upload\Result,
    RichUploader\Upload\Uploader,
    Application\Models\Upload,
    RichUploader\Http\Request;

/**
 * Upload controller
 *
 * @category   Application
 * @package    Controllers
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Upload
{
    /**
     * @var \RichUploader\Upload\Uploader Instance of the uploader
     */
    private $uploader;

    /**
     * @var \Application\Models\Upload The upload model
     */
     private $uploadModel;

    /**
     * @var \RichUploader\Http\Request The request object
     */
     private $request;

    /**
     * Creates instance
     *
     * @param \RichUploader\Upload\Uploader $uploader    Instance of the uploader
     * @param \Application\Models\Upload    $uploadModel The upload model
     * @param \RichUploader\Http\Request    $request     The request object
     */
    public function __construct(Uploader $uploader, Upload $uploadModel, Request $request)
    {
        $this->uploader    = $uploader;
        $this->uploadModel = $uploadModel;
        $this->request     = $request;
    }

    /**
     * Sets up the login view
     *
     * @param \Application\Views\Upload\Result $view     The upload result view
     *
     * @return string The rendered view
     */
    public function process(Result $view)
    {
        $result = $uploader->handleUpload(sys_get_temp_dir())

        if (array_key_exists('success', $result) && $result['success'] === true) {
            try {
                $this->uploadModel->process(sys_get_temp_dir() . '/' . $request->getPathVariable('filename'));
            } catch (\DomainException $e) {
                $result = ['error' => $e->getMessage()];
            }
        }

        $this->setResult($result);

        return $view;
    }
}