<?php


namespace AAllen\Images\Model;

use AAllen\Images\Api\Data\ImageInterface;

class Image extends \Magento\Framework\Model\AbstractModel implements ImageInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AAllen\Images\Model\ResourceModel\Image');
    }

    /**
     * Get image_id
     * @return string
     */
    public function getImageId()
    {
        return $this->getData(self::IMAGE_ID);
    }

    /**
     * Set image_id
     * @param string $imageId
     * @return \AAllen\Images\Api\Data\ImageInterface
     */
    public function setImageId($imageId)
    {
        return $this->setData(self::IMAGE_ID, $imageId);
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return \AAllen\Images\Api\Data\ImageInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get file_name
     * @return string
     */
    public function getFileName()
    {
        return $this->getData(self::FILENAME);
    }

    /**
     * Set file_name
     * @param string $file_name
     * @return \AAllen\Images\Api\Data\ImageInterface
     */
    public function setFileName($file_name)
    {
        return $this->setData(self::FILENAME, $file_name);
    }

    /**
     * Get creation_time
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Set creation_time
     * @param string $creation_time
     * @return \AAllen\Images\Api\Data\ImageInterface
     */
    public function setCreationTime($creation_time)
    {
        return $this->setData(self::CREATION_TIME, $creation_time);
    }

    /**
     * Get update_time
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set update_time
     * @param string $update_time
     * @return \AAllen\Images\Api\Data\ImageInterface
     */
    public function setUpdateTime($update_time)
    {
        return $this->setData(self::UPDATE_TIME, $update_time);
    }

    /**
     * Get is_active
     * @return string
     */
    public function isActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $is_active
     * @return \AAllen\Images\Api\Data\ImageInterface
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }
}
