<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/4/2017
 * Time: 10:42 PM
 */

namespace AAllen\Images\Model\Image\Backend;


class Image extends \Magento\Theme\Model\Design\Backend\Image
{
    /**
     * The tail part of directory path for uploading
     *
     */
    const UPLOAD_DIR = 'aallenimage';

    /**
     * Return path to directory for upload file
     *
     * @return string
     * @throw \Magento\Framework\Exception\LocalizedException
     */
    protected function _getUploadDir()
    {
        return $this->_mediaDirectory->getRelativePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }
}