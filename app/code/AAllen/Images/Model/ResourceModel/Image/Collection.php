<?php


namespace AAllen\Images\Model\ResourceModel\Image;

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
            'AAllen\Images\Model\Image',
            'AAllen\Images\Model\ResourceModel\Image'
        );
    }
}
