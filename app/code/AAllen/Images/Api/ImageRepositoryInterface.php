<?php


namespace AAllen\Images\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ImageRepositoryInterface
{


    /**
     * Save Image
     * @param \AAllen\Images\Api\Data\ImageInterface $image
     * @return \AAllen\Images\Api\Data\ImageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \AAllen\Images\Api\Data\ImageInterface $image
    );

    /**
     * Retrieve Image
     * @param string $imageId
     * @return \AAllen\Images\Api\Data\ImageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($imageId);

    /**
     * Delete Image
     * @param \AAllen\Images\Api\Data\ImageInterface $image
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \AAllen\Images\Api\Data\ImageInterface $image
    );

    /**
     * Delete Image by ID
     * @param string $imageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($imageId);
}
