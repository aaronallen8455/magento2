<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/5/2016
 * Time: 4:32 PM
 */

namespace AAllen\UspsCustomRates\Plugin;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class Price
{
    protected $_scopeConfig;
    protected $_storeManager;
    protected $_customRates;

    /**
     * Price constructor.
     * @param ScopeConfigInterface $scopeConfigInterface
     * @param StoreManagerInterface $storeManagerInterface
     */
    public function __construct(ScopeConfigInterface $scopeConfigInterface, StoreManagerInterface $storeManagerInterface)
    {
        $this->_scopeConfig = $scopeConfigInterface;
        $this->_storeManager = $storeManagerInterface;

        /*$this->setCustomRates(
            $this->_scopeConfig->getValue(
                'carriers/usps/custom_rates',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                $this->_storeManager->getStore()->getCode()
            )
        );*/
    }

    /**
     * Set price rule for usps carrier
     * 
     * @param \Magento\Quote\Model\Quote\Address\RateResult\Method $subject
     * @return null
     */
    public function afterSetPrice($subject)
    {
        // check if usps method
        if ($subject->getCarrier() && $subject->getCarrier() === 'usps') {
            // check if method has a rule
            if ($price = $this->getCustomRate($subject->getMethod())) {
                $subject->setData('price', $price);
            }
        }

        return null;
    }

    /**
     * Match method with a custom rate
     *
     * @param $method
     * @return string
     */
    protected function getCustomRate($method)
    {

        /*// look for a match with this method
        foreach ($this->_customRates as $methodRate) {
            if ($method == $methodRate[0]) {
                return $methodRate[1];
            }
        }
        // no match
        return false;*/
        if (array_key_exists($method, $this->getCustomRates())) {
            return $this->getCustomRates()[$method];
        }
        return false;
    }

    /**
     * Get array of custom rate rules
     *
     * @return array
     */
    protected function getCustomRates()
    {
        if (empty($this->_customRates)) {
            $this->_customRates = unserialize(
                $this->_scopeConfig->getValue(
                    'carriers/usps/custom_rates',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $this->_storeManager->getStore()->getCode()
                )
            );
        }
        return $this->_customRates;
    }


    /**
     * Parse the custom rates into property
     *
     * @param $customRates
     * @return null
     */
    protected function setCustomRates($customRates)
    {
        // decompress the rates. [0] = method, [1] = price
        $customRates = explode(',', $customRates);
        array_walk(
            $customRates,
            function (&$item) {
                $item = explode('|', $item);
            }
        );

        $this->_customRates = $customRates;
        return null;
    }
}