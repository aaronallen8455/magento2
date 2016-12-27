<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 11/27/2016
 * Time: 11:35 PM
 */

namespace AAllen\Fee\Block\Sales\Order;


use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Tax\Model\Config;

class Fee extends Template
{
    protected $_config;

    protected $_order;

    protected $_source;

    public function __construct(Template\Context $context, Config $taxConfig, array $data = [])
    {
        $this->_config = $taxConfig;
        parent::__construct($context, $data);
    }

    /**
     * Check if we need to display full tax total info
     *
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Get data (totals) source model
     *
     * @return mixed
     */
    public function getSource()
    {
        return $this->_source;
    }

    public function getStore()
    {
        return $this->_order->getStore();
    }

    public function getOrder()
    {
        return $this->_order;
    }

    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return $this
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $this->_source = $parent->getSource();

        //$store = $this->getStore();

        $fee = new DataObject(
            [
                'code' => 'fee',
                'strong' => false,
                'value' => 100,
                'label' => __('Fee')
            ]
        );

        $parent->addTotal($fee, 'fee');

        return $this;
    }
}