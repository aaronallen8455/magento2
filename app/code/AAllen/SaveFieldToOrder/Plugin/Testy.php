<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 6/8/2017
 * Time: 5:38 AM
 */

namespace AAllen\SaveFieldToOrder\Plugin;


use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Psr\Log\LoggerInterface;

class Testy
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeSaveAddressInformation(
        $subject,
        $cartId,
        ShippingInformationInterface $addressInfo
    ) {
        $this->logger->debug($addressInfo->getShippingAddress()->getExtensionAttributes()->getCustom());
    }
}