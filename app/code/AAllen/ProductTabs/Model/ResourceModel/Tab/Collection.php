<?php


namespace AAllen\ProductTabs\Model\ResourceModel\Tab;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'AAllen\ProductTabs\Model\Tab',
            'AAllen\ProductTabs\Model\ResourceModel\Tab'
        );
    }
}
