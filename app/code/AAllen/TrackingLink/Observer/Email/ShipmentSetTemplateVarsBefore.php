<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/21/2017
 * Time: 7:02 PM
 */

namespace AAllen\TrackingLink\Observer\Email;


use AAllen\TrackingLink\Helper\Data;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class ShipmentSetTemplateVarsBefore implements ObserverInterface
{
    protected $trackingHelper;

    public function __construct(Data $trackingHelper)
    {
        $this->trackingHelper = $trackingHelper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $transport = $observer->getData('transport');
        /** @var Order\Shipment $shipment */
        $shipment = $transport['shipment'];
        $trackingUrl = $this->trackingHelper->getTrackingPopupUrlBySalesModel($shipment);
        $shipment->setData('tracking_url', $trackingUrl);
    }
}