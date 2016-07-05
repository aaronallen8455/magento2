<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AAllen\UspsCustomRates\Model;

use Magento\Shipping\Model\Rate\Result;
use Magento\Framework\Xml\Security;
use Magento\Shipping\Helper\Carrier as CarrierHelper;

/**
 * USPS shipping
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Carrier extends \Magento\Usps\Model\Carrier implements \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /** @var  array $_customRates */
    protected $_customRates;

    /**
     * Set custom rates
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

    /**
     * Parse calculated rates
     *
     * @param string $response
     * @return Result
     * @link http://www.usps.com/webtools/htm/Rate-Calculators-v2-3.htm
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _parseXmlResponse($response)
    {
        $r = $this->_rawRequest;
        $costArr = [];
        $priceArr = [];
        if (strlen(trim($response)) > 0) {
            if (strpos(trim($response), '<?xml') === 0) {
                if (strpos($response, '<?xml version="1.0"?>') !== false) {
                    $response = str_replace(
                        '<?xml version="1.0"?>',
                        '<?xml version="1.0" encoding="ISO-8859-1"?>',
                        $response
                    );
                }
                $xml = $this->parseXml($response);

                if (is_object($xml)) {
                    $allowedMethods = explode(',', $this->getConfigData('allowed_methods'));
                    $serviceCodeToActualNameMap = [];
                    /**
                     * US Rates
                     */
                    if ($this->_isUSCountry($r->getDestCountryId())) {
                        if (is_object($xml->Package) && is_object($xml->Package->Postage)) {
                            foreach ($xml->Package->Postage as $postage) {
                                $serviceName = $this->_filterServiceName((string)$postage->MailService);
                                $_serviceCode = $this->getCode('method_to_code', $serviceName);
                                $serviceCode = $_serviceCode ? $_serviceCode : (string)$postage->attributes()->CLASSID;
                                $serviceCodeToActualNameMap[$serviceCode] = $serviceName;
                                if (in_array($serviceCode, $allowedMethods)) {
                                    $costArr[$serviceCode] = (string)$postage->Rate;
                                    $priceArr[$serviceCode] = $this->getMethodPrice(
                                        (string)$postage->Rate,
                                        $serviceCode
                                    );
                                }
                            }
                            asort($priceArr);
                        }
                    } else {
                        /*
                         * International Rates
                         */
                        if (is_object($xml->Package) && is_object($xml->Package->Service)) {
                            foreach ($xml->Package->Service as $service) {
                                $serviceName = $this->_filterServiceName((string)$service->SvcDescription);
                                $serviceCode = 'INT_' . (string)$service->attributes()->ID;
                                $serviceCodeToActualNameMap[$serviceCode] = $serviceName;
                                if (!$this->isServiceAvailable($service)) {
                                    continue;
                                }
                                if (in_array($serviceCode, $allowedMethods)) {
                                    $costArr[$serviceCode] = (string)$service->Postage;
                                    $priceArr[$serviceCode] = $this->getMethodPrice(
                                        (string)$service->Postage,
                                        $serviceCode
                                    );
                                }
                            }
                            asort($priceArr);
                        }
                    }
                }
            }
        }

        $result = $this->_rateFactory->create();
        if (empty($priceArr)) {
            $error = $this->_rateErrorFactory->create();
            $error->setCarrier('usps');
            $error->setCarrierTitle($this->getConfigData('title'));
            $error->setErrorMessage($this->getConfigData('specificerrmsg'));
            $result->append($error);
        } else {
            foreach ($priceArr as $method => $price) {
                $rate = $this->_rateMethodFactory->create();
                $rate->setCarrier('usps');
                $rate->setCarrierTitle($this->getConfigData('title'));
                $rate->setMethod($method);
                $rate->setMethodTitle(
                    isset(
                        $serviceCodeToActualNameMap[$method]
                    ) ? $serviceCodeToActualNameMap[$method] : $this->getCode(
                        'method',
                        $method
                    )
                );
                $rate->setCost($costArr[$method]);

                // Customize the setPrice method here.
                // todo: create plug in for setPrice detecting the getCarrier as 'usps'
                $rate->setPrice($this->getCustomRate($method, $price));
                $result->append($rate);
            }
        }

        return $result;
    }

    /**
     * Match method with a custom rate
     *
     * @param $method
     * @param $price
     * @return string
     */
    protected function getCustomRate($method, $price)
    {
        if (!$this->_customRates) {
            $this->setCustomRates($this->getConfigData('custom_rates'));
        }

        // look for a match with this method
        foreach ($this->_customRates as $methodRate) {
            if ($method == $methodRate[0]) {
                return $methodRate[1];
            }
        }
        // no match, return base price
        return $price;
    }
}
