<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 4/24/2017
 * Time: 6:08 AM
 */

namespace AAllen\Test\Observer;


use Magento\Catalog\Model\Product;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote\Item;

class Price implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $itemPrice = 15;
        /** @var Item $quoteItem */
        $quoteItem = $observer->getData('quote_item');
        /** @var Product $product */
        $product = $observer->getData('product');

        if ($product->getSku() == 'upgrade') {
            $quoteItem->setCustomPrice($itemPrice);
            $quoteItem->setOriginalCustomPrice($itemPrice);
        }
        //$quoteItem->setCustomPrice(15);

        //$infoBuyRequest = $quoteItem->getBuyRequest();
        //if ($infoBuyRequest) {
        //    $infoBuyRequest->setCustomPrice($itemPrice);
//
        //    $infoBuyRequest->setValue(serialize($infoBuyRequest->getData()));
        //    $infoBuyRequest->setCode('info_buyRequest');
        //    $infoBuyRequest->setProduct($quoteItem->getProduct());
//
        //    $quoteItem->addOption($infoBuyRequest);
        //}


    }
}