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
    protected $_menuBlockCollection;
    protected $_themeProvider;

    public function __construct(
        Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \AAllen\MenuBlock\Model\ResourceModel\Block\CollectionFactory $menuBlockCollectionFactory,
        \Magento\Framework\View\Design\Theme\ThemeProviderInterface $themeProvider,
        array $data)
    {
        $this->_menuBlockCollection = $menuBlockCollectionFactory->create();
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_passedData = $data;
        $this->_themeProvider = $themeProvider;
        parent::__construct($context, $data);
    }

    public function testDataObject() {
        $obj = new \Magento\Framework\DataObject(
            [
                'code' => 'grand_total',
                'field' => 'grand_total',
                'strong' => true,
                'value' => 20,
                'label' => __('Grand Total'),
            ]
        );

        return $obj->getCode();
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

    public function getPrice()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('price');
        $collection->addFieldToFilter('entity_id', 51);
        $price = 0;
        foreach ($collection as $product) {
            if ($product->getPrice()) {
                $price = $product->getPrice() . ' ' . get_class($product);
                if ($product->isSalable()) $price .= ' salabe';
                break;
            }
        }
        return $price;
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

    public function getThemeData()
    {
        $themeId = $this->_scopeConfig->getValue(
            \Magento\Framework\View\DesignInterface::XML_PATH_THEME_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getId()
        );

        /** @var $theme \Magento\Framework\View\Design\ThemeInterface */
        $theme = $this->_themeProvider->getThemeById($themeId);

        return print_r($theme->getData(), true);
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

    public function getModuleName()
    {
        return 'Magento_Catalog';
    }

    public function getRead()
    {
        $array = $this->_viewConfig->getViewConfig()->read();

        function walk($array) {
            $html = '<ul>';
            foreach ($array as $key => $value) {
                $html .= '<li>';
                $html .= "<span>$key</span>";
                if (is_array($value)) {
                    $html .= walk($value);
                }else{
                    $html .= "<span> -> $value</span>";
                }

                $html .= '</li>';
            }
            $html .= '</ul>';

            return $html;
        }

        return walk($array);
    }

    public function menuBlockData()
    {
        foreach ($this->_menuBlockCollection as $block) {
            \Zend_Debug::dump($block->getId());
        }

        \Zend_Debug::dump(get_class($this->_menuBlockCollection));

        $items = $this->_menuBlockCollection->getItems();
        foreach ($items as $block) {
            return print_r($block->getData(), true);
        }
    }
}