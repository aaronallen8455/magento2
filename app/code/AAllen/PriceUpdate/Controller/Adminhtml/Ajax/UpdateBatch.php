<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 8/8/2016
 * Time: 9:06 PM
 */

namespace AAllen\PriceUpdate\Controller\Adminhtml\Ajax;


use Magento\Backend\App\Action;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;


class UpdateBatch extends Action
{
    /** @var ProductRepositoryInterface $productRepo */
    protected $productRepo;

    /** @var CollectionFactory $productCollectionFactory */
    protected $productCollectionFactory;

    public function __construct(
        Action\Context $context,
        ProductRepositoryInterface $productRepository,
        CollectionFactory $productCollectionFactory
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productRepo = $productRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        // get parameters
        $amount = $this->getRequest()->getParam('amount');
        $isConstant = $this->getRequest()->getParam('is_constant') == 1; // true if not a percent change
        $pageSize = $this->getRequest()->getParam('page_size');
        $currentPage = $this->getRequest()->getParam('current_page');

        if (is_numeric($amount) && $amount != 0) {
            /** @var Collection $products */
            $products = $this->productCollectionFactory->create()
                ->addAttributeToSelect('price')
                ->setPageSize($pageSize)
                ->setCurPage($currentPage);

            /** @var \Magento\Catalog\Model\Product $product */
            foreach ($products as $product) {

                // skip un-salable items
                if (!$product->getPrice()) continue;

                // check if adding percentage or constant
                if ($isConstant) {
                    $price = $product->getPrice() + $amount;
                }else{
                    $price = round($product->getPrice() + ($amount/100 * $product->getPrice()), 2);
                }

                // if below zero, set to zero
                $price = $price >= 0 ? $price : 0;

                // save the price change
                try{
                    $product->setPrice($price);
                    $this->productRepo->save($product); // save the entity
                }catch (\Exception $error){
                    exit('Error on product id ' . $product->getId());
                }
            }
        }

        echo 'Done'; // send completion message
    }

    /**
     * Is the user allowed to update prices.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AAllen_PriceUpdate::update');
    }
}