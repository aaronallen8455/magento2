<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:16 AM
 */

namespace AAllen\Sandbox\Block;


use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Block extends Template
{
    protected $_passedData;
    protected $_productCollectionFactory;

    public function __construct(Context $context, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, array $data)
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_passedData = $data;
        parent::__construct($context, $data);
    }

    public function printData()
    {
        return print_r(current($this->_data), true);
    }
    
    public function testProductMethod()
    {
        $collection = $this->_productCollectionFactory->create();
        return $collection->testMethod();
    }
}