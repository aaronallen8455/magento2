<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 11/27/2016
 * Time: 10:50 PM
 */

namespace AAllen\Fee\Model\Total;


use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Quote\Model\QuoteValidator;

class Fee extends AbstractTotal
{

    protected $quoteValidator = null;

    public function __construct(QuoteValidator $quoteValidator)
    {
        $this->setCode('fee');
        $this->quoteValidator = $quoteValidator;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);

        $balance = 100;

        $total->addTotalAmount('fee', $balance);
        $total->addBaseTotalAmount('fee', $balance);

        //$total->setTotalAmount('fee', $balance);
        //$total->setBaseTotalAmount('fee', $balance);
//
        //$total->setFee($balance);
        //$total->setBaseFee($balance);
//
        //$total->setGrandTotal($total->getGrandTotal() + $balance);
        //$total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);

        return $this;
    }

    protected function clearValues(Total $total)
    {
        $total->setTotalAmount('subtotal', 0)
            ->setBaseTotalAmount('subtotal', 0)
            ->setTotalAmount('tax', 0)
            ->setBaseTotalAmount('tax', 0)
            ->setTotalAmount('discount_tax_compensation', 0)
            ->setBaseTotalAmount('discount_tax_compensation', 0)
            ->setTotalAmount('shipping_discount_tax_compensation', 0)
            ->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code' => $this->getCode(),
            'title' => __('Fee'),
            'value' => 100
        ];
    }

    public function getLabel()
    {
        return __('Fee');
    }
}