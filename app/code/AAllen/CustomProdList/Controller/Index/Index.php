<?php

namespace AAllen\CustomProdList\Controller\Index;


use AAllen\CustomProdList\Block\Product\CustomList;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /** @var PageFactory */
    protected $pageFactory;

    /** @var  \Magento\Catalog\Model\ResourceModel\Product\Collection */
    protected $productCollection;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    )
    {
        $this->pageFactory = $pageFactory;
        $this->productCollection = $collectionFactory->create();

        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->pageFactory->create();

        // obtain product collection.
        $this->productCollection->addIdFilter([5, 2, 22]); // do some filtering
        $this->productCollection->addFieldToSelect('*');

        // get the custom list block and add our collection to it
        /** @var CustomList $list */
        $list = $result->getLayout()->getBlock('custom.products.list');
        $list->setProductCollection($this->productCollection);

        return $result;
    }
}