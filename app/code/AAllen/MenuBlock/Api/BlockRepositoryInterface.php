<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AAllen\MenuBlock\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use AAllen\MenuBlock\Api\Data\BlockInterface;

/**
 * CMS block CRUD interface.
 * @api
 */
interface BlockRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \AAllen\MenuBlock\Api\Data\BlockInterface $block
     * @return \AAllen\MenuBlock\Api\Data\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\BlockInterface $block);

    /**
     * Retrieve block.
     *
     * @param int $blockId
     * @return BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($blockId);

    /**
     * Delete block.
     *
     * @param \AAllen\MenuBlock\Api\Data\BlockInterface $block
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\BlockInterface $block);

    /**
     * Delete block by ID.
     *
     * @param int $blockId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($blockId);
}
