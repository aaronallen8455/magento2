<?php


namespace AAllen\Sandbox\Block;


use Magento\Framework\View\Element\Template;

class Statistics extends Template
{
    protected $bestSellerCollection;
    protected $mostViewedCollection;
    protected $wishListHelper;

    public function __construct(
        Template\Context $context,
        \Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory $bestSellerCollectionFactory,
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $mostViewedCollectionFactory,
        \Magento\Wishlist\Helper\Data $wishListHelper,
        array $data = []
    ) {
        $this->bestSellerCollection = $bestSellerCollectionFactory->create();
        $this->mostViewedCollection = $mostViewedCollectionFactory->create();
        $this->wishListHelper = $wishListHelper;
        parent::__construct($context, $data);
    }

    public function getBestSellers()
    {
        $this->bestSellerCollection->setModel('Magento\Catalog\Model\Product')
            ->addStoreFilter($this->_storeManager->getStore()->getId());

        return $this->bestSellerCollection;
    }

    public function getMostViewed()
    {
        $storeId = $this->_storeManager->getStore()->getId();

        $this->mostViewedCollection->addAttributeToSelect(
            '*'
        )->addViewsCount()->setStoreId(
            $storeId
        )->addStoreFilter(
            $storeId
        );

        return $this->mostViewedCollection;
    }

    public function getWishlist()
    {
        //$collection = $this->wishListHelper->getWishlist()->getItemCollection();
        //$collection->setInStockFilter(true)->setOrder('added_at', 'ASC');

        $collection = $this->wishListHelper->getWishlist()->getCollection();

        return $collection;
    }
}