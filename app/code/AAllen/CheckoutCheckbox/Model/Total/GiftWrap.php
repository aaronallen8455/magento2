<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 3/28/2017
 * Time: 8:30 PM
 */

namespace AAllen\CheckoutCheckbox\Model\Total;




use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

class GiftWrap extends AbstractTotal
{
    const GIFTWRAP_COST = 25;

    protected $isAdded;

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        // check if box was checked
        if ($quote->getIsGiftwrapped() == true) {
            $total->addTotalAmount('giftwrap', self::GIFTWRAP_COST);
            $total->addBaseTotalAmount('giftwrap', self::GIFTWRAP_COST);
            $this->isAdded = true;
        }
        else {
            if ($this->isAdded) {
                $total->addBaseTotalAmount('giftwrap', self::GIFTWRAP_COST * -1);
                $total->addTotalAmount('giftwrap', self::GIFTWRAP_COST * -1);
            }
            $this->isAdded = false;
        }

        return $this;
    }

    public function getCode()
    {
        return 'giftwrap';
    }

    public function getLabel()
    {
        return __('Giftwrap');
    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code' => $this->getCode(),
            'title' => $this->getLabel(),
            'value' => $quote->getIsGiftwrapped() ? self::GIFTWRAP_COST : 0
        ];
    }
}