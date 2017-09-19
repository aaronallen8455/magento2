<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/2/2016
 * Time: 3:16 AM
 */

namespace AAllen\Sandbox\Block;


use Magento\Backend\Block\Dashboard\Tab\Products\Ordered;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderRepository;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class Block extends Template
{
    protected $_passedData;
    protected $_productCollectionFactory;
    protected $_menuBlockCollection;
    protected $_themeProvider;
    protected $pageRepository;
    protected $searchCriteriaBuilder;
    protected $storeGroupResource;
    protected $cart;
    protected $cartHelper;
    protected $checkoutSession;
    protected $imageBuilder;
    protected $orderRepository;
    protected $componentRegistrar;
    protected $shipmentInfo;
    protected $bestSellersCollection;

    public function __construct(
        Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \AAllen\MenuBlock\Model\ResourceModel\Block\CollectionFactory $menuBlockCollectionFactory,
        \Magento\Framework\View\Design\Theme\ThemeProviderInterface $themeProvider,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Store\Model\ResourceModel\Group $group,
        Cart $cart,
        \Magento\Checkout\Helper\Cart $cartHelper,
        Session $session,
        ImageBuilder $imageBuilder,
        OrderRepository $orderRepository,
        ComponentRegistrarInterface $componentRegistrar,
        ShipmentInfo $shipmentInfo,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $collectionFactory,
        array $data)
    {
        $this->checkoutSession = $session;
        $this->cartHelper = $cartHelper;
        $this->cart = $cart;
        $this->storeGroupResource = $group;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->pageRepository = $pageRepository;
        $this->_menuBlockCollection = $menuBlockCollectionFactory->create();
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_passedData = $data;
        $this->_themeProvider = $themeProvider;
        $this->imageBuilder = $imageBuilder;
        $this->orderRepository = $orderRepository;
        $this->componentRegistrar = $componentRegistrar;
        $this->shipmentInfo = $shipmentInfo;
        $this->bestSellersCollection = $collectionFactory->create();
        parent::__construct($context, $data);
    }

    public function getBestSellers()
    {
        $this->bestSellersCollection->setModel(
            'Magento\Catalog\Model\Product'
        )->addStoreFilter($this->_storeManager->getStore()->getId());

        return $this->bestSellersCollection;
    }

    public function getCartItemCount()
    {
        return $this->cart->getItemsCount();
        /**
         * can get from JS localStorage like this
         * JSON.parse(window.localStorage.getItem('mage-cache-storage')).cart.summary_count;
         */
    }

    public function getModuleDir($name)
    {
        $path = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, $name);

        return $path;
    }

    public function inCart()
    {
        $quote = $this->checkoutSession->getQuote();

    }

    public function getShipFromTrack()
    {
        $shipment = $this->shipmentInfo->getShipmentFromTrackingNumber('ABC123');

        return $shipment->getCreatedAt();
    }

    public function getShipMethod()
    {
        $order = $this->orderRepository->get(1);
        return $order->getShippingMethod();
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

    public function changeRootCat()
    {
        /** @var Store $store */
        $store = $this->_storeManager->getStore();
        $group = $store->getGroup();
        $group->setRootCategoryId(2);
        try {
            //$group->save();
            $this->storeGroupResource->save($group);
        }catch (\Exception $e) {
            \Zend_Debug::dump($e);
        }
    }

    public function printData()
    {
        return print_r(current($this->_data), true);
    }

    public function getPageAttribute($attributeName, $pageId)
    {
        $page = $this->pageRepository->getById($pageId);

        return $page->getData($attributeName);
    }

    public function getPayment()
    {
        /** @var Order $order */
        $order = $this->orderRepository->get(1);
        /** @var Order\Payment $payment */
        $payment = $order->getPayment();
        $method = $payment->getMethodInstance();
        $methodTitle = $method->getTitle();
    }

    public function getProductNames()
    {
        /** @var Collection $collection */
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addOrder('name', \Magento\Framework\Data\Collection::SORT_ORDER_ASC)->addOrder('price');
        $collection->setPageSize(30);
        $collection->setCurPage(1);
        $collection->load();
        $select = $collection->getSelectSql(true);
        \Zend_Debug::dump(substr($select, -100));
        /** @var Product $item */
        foreach ($collection as $item){
            var_dump($item->getName());
            //var_dump($this->imageBuilder->setProduct($item)->setImageId('category_page_grid')->create()->getImageUrl());
            //var_dump($item->getData());
            //var_dump($item->getCategoryIds());
            //$categories = $item->getCategoryCollection()->addFieldToSelect('name');
            //foreach ($categories as $category) {
            //    var_dump($category->getName());
            //}
            break;
        }
        $this->imageBuilder
            ->setProduct($item)
            ->setImageId('category_page_grid')
            ->create();
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