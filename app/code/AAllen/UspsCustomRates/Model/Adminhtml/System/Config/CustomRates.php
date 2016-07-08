<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/7/2016
 * Time: 5:20 PM
 */

namespace AAllen\UspsCustomRates\Model\Adminhtml\System\Config;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Math\Random;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class CustomRates extends Value
{
    protected $mathRandom;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        Random $mathRandom,
        AbstractResource $resource,
        AbstractDb $resourceCollection,
        array $data = []
    )
    {
        $this->mathRandom = $mathRandom;

        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        $value = $this->getValue();
        $result = [];
        foreach ($value as $data) {
            if (empty($data['method_code']) || empty($data['price'])) {
                continue;
            }
            $method = $data['method_code'];
            
            $result[$method] = $data['price'];
        }
        $this->setValue(serialize($result));
        return $this;
    }
    
    public function afterLoad()
    {
        $value = unserialize($this->getValue());
        if (is_array($value)) {
            $value = $this->encodeArrayFieldValue($value);
            $this->setValue($value);
        }
        return $this;
    }

    /**
     * Encode value to be used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function encodeArrayFieldValue(array $value)
    {
        $result = [];
        foreach ($value as $country => $creditCardType) {
            $id = $this->mathRandom->getUniqueHash('_');
            $result[$id] = ['method_code' => $country, 'price' => $creditCardType];
        }
        return $result;
    }
}