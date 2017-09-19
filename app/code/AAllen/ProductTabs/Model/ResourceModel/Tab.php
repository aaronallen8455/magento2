<?php


namespace AAllen\ProductTabs\Model\ResourceModel;

class Tab extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('aallen_producttabs_tab', 'tab_id');
    }
}
