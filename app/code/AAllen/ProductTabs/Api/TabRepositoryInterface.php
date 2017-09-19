<?php


namespace AAllen\ProductTabs\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TabRepositoryInterface
{


    /**
     * Save Tab
     * @param \AAllen\ProductTabs\Api\Data\TabInterface $tab
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \AAllen\ProductTabs\Api\Data\TabInterface $tab
    );

    /**
     * Retrieve Tab
     * @param string $tabId
     * @return \AAllen\ProductTabs\Api\Data\TabInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($tabId);

    /**
     * Retrieve Tab matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AAllen\ProductTabs\Api\Data\TabSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Tab
     * @param \AAllen\ProductTabs\Api\Data\TabInterface $tab
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \AAllen\ProductTabs\Api\Data\TabInterface $tab
    );

    /**
     * Delete Tab by ID
     * @param string $tabId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($tabId);
}
