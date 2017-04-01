<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/27/2017
 * Time: 3:53 PM
 */

namespace AAllen\Sandbox\Block;


use Magento\Sales\Api\Data\ShipmentTrackInterface;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\ResourceModel\Order\Shipment\Track\CollectionFactory as TrackCollectionFactory;

class ShipmentInfo
{

    /** @var  \Magento\Sales\Model\ResourceModel\Order\Shipment\Track\Collection */
    protected $trackingCollection;

    public function __construct(TrackCollectionFactory $collectionFactory)
    {
        $this->trackingCollection = $collectionFactory->create();
    }

    public function getShipmentFromTrackingNumber($number)
    {
        try {
            $this->trackingCollection
                ->addFieldToFilter(ShipmentTrackInterface::TRACK_NUMBER, $number);
            /** @var Shipment\Track $tracking */
            $tracking = $this->trackingCollection->getFirstItem();
            /** @var Shipment $shipment */
            $shipment = $tracking->getShipment();

            return $shipment;
        }
        catch (\Magento\Framework\Exception\LocalizedException $e) {}

        return null;
    }
}