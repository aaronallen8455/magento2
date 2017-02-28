<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/16/2017
 * Time: 8:54 PM
 */

namespace AAllen\Sandbox\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class ShippingVars implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $transport = $observer->getData('transport');
        /** @var Order $order */
        $order = $transport['order'];
        $methodCode = $order->getShippingMethod();

        // add variables
        $transport['is_pickup'] = $methodCode == 'flatrate_flatrate';
        $transport['is_delivery'] = $methodCode != 'flatrate_flatrate';

        $observer->setData('transport', $transport);

        return $this;
    }
}