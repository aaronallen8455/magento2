<?php


namespace AAllen\ProductTabs\Api\Data;

interface TabSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Tab list.
     * @return \AAllen\ProductTabs\Api\Data\TabInterface[]
     */
    public function getItems();

    /**
     * Set tab_id list.
     * @param \AAllen\ProductTabs\Api\Data\TabInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
