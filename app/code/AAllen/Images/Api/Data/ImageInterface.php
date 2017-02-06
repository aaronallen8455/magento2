<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/4/2017
 * Time: 6:00 PM
 */

namespace AAllen\Images\Api\Data;


interface ImageInterface
{

    const IMAGE_ID = 'image_id';
    const TITLE = 'title';
    const FILENAME = 'file_name';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';

    const IMAGE_PATH = 'images/';
    const TMP_IMAGE_PATH = 'images/tmp/';

    /**
     * Get ID
     * @return int
     */
    public function getId();

    /**
     * Get title
     * @return string
     */
    public function getTitle();

    /**
     * Get filename
     * @return string
     */
    public function getFileName();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return ImageInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return ImageInterface
     */
    public function setTitle($title);

    /**
     * Set file name
     * @param $fileName
     * @return ImageInterface
     */
    public function setFileName($fileName);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return ImageInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return ImageInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return ImageInterface
     */
    public function setIsActive($isActive);

    /**
     * Get full image url
     *
     * @return string
     */
    public function getUrl();
}