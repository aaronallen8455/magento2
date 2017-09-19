<?php


namespace AAllen\SaveFieldToOrder\Observer\Sales;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Sales\Model\Order\AddressRepository;
use Psr\Log\LoggerInterface;

class ModelServiceQuoteSubmitBefore implements \Magento\Framework\Event\ObserverInterface
{
    protected  $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $observer->getEvent()->getOrder();

        $customField = $quote->getShippingAddress()->getExtensionAttributes();

        //$this->logger->debug(count($quote->getShippingAddress()->getCustomAttributes()));

        if (!is_null($customField)) {
            $order->setData('custom_field', $customField->getCustom);
        }

        return $this;
    }
}
