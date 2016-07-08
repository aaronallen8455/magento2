<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/7/2016
 * Time: 4:39 PM
 */

namespace AAllen\UspsCustomRates\Block\Adminhtml\Form\Field;


use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class Methods extends Select
{
    private $methodHelper;
    
    public function __construct(Context $context, \AAllen\UspsCustomRates\Helper\Methods $methodHelper, array $data = [])
    {
        parent::__construct($context, $data);
        $this->methodHelper = $methodHelper;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getOptions()) {
            $options = $this->methodHelper->getMethods();
            array_unshift($options, ['label' => 'None', 'value' => 'none']);
            $this->setOptions($options);
        }
        return parent::_toHtml();
    }

    /**
     * Sets name for input element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}