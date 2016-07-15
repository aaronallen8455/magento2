<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:16 AM
 */

namespace AAllen\Sandbox\Block;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class Block extends Template
{
    protected $_passedData;
    protected $_productCollectionFactory;

    public function __construct(
        Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data)
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

    public function checkData()
    {
        $data = $this->_scopeConfig->getValue(
            'carriers/usps/custom_rates_array',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getCode()
        );
        $data = unserialize($data);
        return print_r($data, true);
    }

    public function checkData2()
    {
        $data = $this->_scopeConfig->getValue(
            'carriers/usps/custom_rates_array',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getId()
        );
        $data = unserialize($data);
        return print_r($data, true);
    }
    
    public function getSalesEmail()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_sales/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getId()
        );
    }
    
    public function getSalesName()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_sales/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getId()
        );
    }
    
}