<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/8/2016
 * Time: 8:52 PM
 */

namespace AAllen\PriceUpdate\Block;



use Magento\Backend\Block\Template;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class PriceUpdate extends Template
{
    const PAGE_SIZE = 8;

    /** @var  Collection $productCollection */
    protected $productCollection;

    /**
     * PriceUpdate constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(Template\Context $context, CollectionFactory $collectionFactory, array $data)
    {
        $this->productCollection = $collectionFactory->create();
        $this->setTemplate('AAllen_PriceUpdate::priceupdate.phtml');
        parent::__construct($context, $data);
    }

    /**
     * Get number of pages at given page size.
     * @return int
     */
    public function getNumberOfPages()
    {
        return $this->productCollection->setPageSize(self::PAGE_SIZE)->getLastPageNumber();
    }

    public function getPageSize()
    {
        return self::PAGE_SIZE;
    }
}